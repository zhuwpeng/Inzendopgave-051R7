<?php 
function get_navbar() {
	//Check if any user_id has been set in session
	if (isset($_SESSION['user_id'])) {
		echo "<div class=\"navbar-wrap\">
					<ul class=\"nav\">
  					<li><a href=\"index.php\">Home</a></li>
  					<li><a href=\"post.php\">Create Post</a></li>
 					<li><a href=\"index.php?page=editposts\">Edit Posts</a></li>
  					<li class=\"nav-login\"><a href=\"logout.php\">Logout</a></li>
  					</ul>
				</div>";
	} else {
		echo "<div class=\"navbar-wrap\">
					<ul class=\"nav\">
					<li><a href=\"index.php\">Home</a></li>
					<li class=\"nav-login\"><a href=\"login.php\">Login</a></li>
					<li class=\"nav-login\"><a href=\"register.php\">Register</a></li>
					</ul>
				</div>";
	}
}

/**
 * @desc: Validates userinput e-mail
 * @param: e-mail $email
 * @return: string
 */
function test_email($email, $logreg)
{
	$match_pattern = '/^[a-zA-Z]*[a-zA-Z]*@[a-zA-Z]*[a-zA-Z]*.nl$/';
	$match = preg_match($match_pattern, $email);

	if ($match) {
		$explode_result = explode("@", $email);
		$explode_result_domain = explode(".", $explode_result[1]);
		$name = $explode_result[0];
		$domain =$explode_result_domain[0];
	
		if (strlen($name) < 2 || strlen($domain) < 2) {
			return false;
		} else {
			if($logreg == "Register"){
				if (preg_match('/admin/i', $email)) {
					return false;
				} else {
					return true;
				}
			} else {
				return true;
			}
		}
	} else {
		return false;
	}
}

//Own error handler
function error_msg($err_type, $err_msg, $err_file, $err_line){
	echo "<div class = 'errorMsg'>";
	echo "<p><b>Error:</b> Oops something went wrong! Please try again later or send an e-mail to admin@admin.nl and report the issue.<br />";
	echo "Error type: $err_type: $err_msg in $err_file at line $err_line";
	echo "</div>";

}

/**
 * @desc: Retrieves all the bloggers that are registered
 * @param: dbconnection $connect
 * @return: string
 */
function get_bloggers($connect) {
	$query = "SELECT user_id, name, ln_prefix, surname FROM users WHERE usertype != 'Admin'";
	$queryResult = mysqli_query($connect, $query) or die("Could not retrieve data from database. " . mysqli_query($connect));
	$numRows = mysqli_num_rows($queryResult);

	if($numRows > 0) {
		while($bloggers = mysqli_fetch_assoc($queryResult)){
			echo "<li><a href=index.php?id=". $bloggers['user_id'] . ">". $bloggers['name'] . " " . stripslashes($bloggers['ln_prefix']) . " " . $bloggers['surname'] ."</a></li>";
		}
	} else {
		echo "No bloggers registered";
	}

}

function random_char($string) {
	$length = strlen($string);
	$position = mt_rand(0, $length - 1);
	return($string[$position]);
}

function random_string($charsetString, $length) {
	$returnString = "";
	for ($x = 0; $x < $length; $x++) {
		$returnString .= random_char($charsetString);
	}
	return($returnString);
}

function random_password() {
	mt_srand((double)microtime() * 1000000);
	$smallSet = "abcdefghijklmnopqrstuvwxyz";
	$capitalSet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$specialSet = "!@#$%^&*(){}[]?";
	$numbersSet = "0123456789";

	$randomPassword = random_string($smallSet, 1);
	$randomPassword .= random_string($capitalSet, 1);
	$randomPassword .= random_string($specialSet, 1);
	$randomPassword .= random_string($numbersSet, 1);

	$randomPassword .= random_string($smallSet.$capitalSet.$specialSet.$numbersSet, 4);

	return str_shuffle($randomPassword);
}

/**
 * @desc: Retrieves blogposts or only the titles for editing or deleting blogposts
 * @param: name $name, dbconnection $connect, bool $postTitle
 * @return: blogposts or titles string
 */
function get_blogposts($id, $connect, $postTitle) {
	$bloggerID = $id;
	//Retrieve posts made by the blogger and blogger data
	$bloggerdataQuery = "SELECT name, ln_prefix, surname, email FROM users WHERE user_id ='$bloggerID'";
	$bloggerdataResult = mysqli_query($connect, $bloggerdataQuery) or die("Could not retrieve information. " . mysqli_error($connect));
	 
	if (mysqli_num_rows($bloggerdataResult) == 1) {
		$bloggerData = mysqli_fetch_assoc($bloggerdataResult);
		$bloggerName = $bloggerData['name'];
		$bloggerPref = $bloggerData['ln_prefix'];
		$bloggerSur = $bloggerData['surname'];
		$bloggerEmail = $bloggerData['email'];
	}
	
	//Retrieve blogposts
	if ($bloggerEmail == "admin@admin.nl") {
		$blogpostQuery = "SELECT post_id, post_author, post_title, post_content, post_date, post_edited FROM posts ORDER BY post_date DESC";
	} else {
		$blogpostQuery = "SELECT post_id, post_author, post_title, post_content, post_date, post_edited FROM posts WHERE post_author ='$bloggerID' ORDER BY post_date DESC";
	}
	
	$blogpostResult = mysqli_query($connect, $blogpostQuery) or die("Could not retrieve data. " . mysqli_error($connect));
	 
	if (mysqli_num_rows($blogpostResult) > 0) {
		while ($blogpost = mysqli_fetch_assoc($blogpostResult)){
			$postID = $blogpost['post_id'];
			$title = $blogpost['post_title'];
			$content = nl2br($blogpost['post_content']);
			$postDate = $blogpost['post_date'];
			
			$splitDateTime = explode(" ", $postDate);
			$date = explode("-", $splitDateTime[0]);
			$time = $splitDateTime[1];
			
			$reformatDate = $date[2] . "-" . $date[1] . "-" . $date[0];
			
			if(!empty($blogpost['post_edited'])){
				$edited = "Last edited on:";
			} else {
				$edited = "Date of creation:";
			}
			
			if (!$postTitle) {
				echo "<div class=\"post-wrapper\">
				<div class=\"post-content\">
					<h3>$title</h3>
					<p class=\"namedate\"><b>$bloggerName $bloggerPref $bloggerSur</b> | $edited" . " " . "$reformatDate" . " time: " . "$time<p>
				</div>
				<div class=\"post-body\">
					$content
				</div>
				</div>";
			} else {
				echo "<tr>
						<td>$title</td>
						<td>$postDate</td>
						<td><a href=\"post.php?editPID=$postID\">Edit</a></td>
						<td><a href=\"?deletePID=$postID\">Remove</a></td>
					</tr>";
			}
		}
	} else {
		echo "<h2>No blog post created yet!</h2>";
	}
}

/**
 * @desc: Creates a blogpost and saves it into the database or updates a blogpost
 * @param: dbconnection $connect, blogpost id $postID, authorID $authorID, blog title $title, content $content, bool $edited
 * @return: string
 */
function create_post($connect, $postID, $authorID, $title, $content, $edited) {
	$author = $authorID;
	$postTitle = mysqli_real_escape_string($connect, $title);
	$postContent = mysqli_real_escape_string($connect, $content);
	$date = mysqli_real_escape_string($connect, date('Y-m-d H:i:s'));
	
	//Check if the blog post is being edited or not
	if (!$edited) {
		$insertQuery = "INSERT INTO posts (post_id,
											post_author,
											post_title,
											post_content,
											post_date,
											post_edited) 
									VALUES ('NULL',
											'$author',
											'$postTitle',
											'$postContent',
											'$date',
											'0')";
	} else {
		$insertQuery = "UPDATE posts SET post_title = '$postTitle',
											post_content = '$postContent',
											post_date = '$date',
											post_edited = '1'
									WHERE post_id = '$postID'";
	}
	
	$insertResult = mysqli_query($connect, $insertQuery) or die("Could not insert data into the database. " . mysqli_error($connect));
	
// 	if (mysqli_affected_rows($connect) == 1 && !$edited) {
// 		return "Your blogpost has been created!";
// 	} else {
// 		return "Your blogpost has been edited!";
// 	}

	if (mysqli_affected_rows($connect) == 1) {
		return true;
	}
}
