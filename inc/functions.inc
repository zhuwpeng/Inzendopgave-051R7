<?php 
function get_navbar() {
	//Check if any user_id has been set in session
	if (isset($_SESSION['user_id'])) {
		echo "<div class=\"navbar-wrap\">
					<ul class=\"nav\">
					<li><a href=\"index.php\">Home</a></li>
					<li><a href=\"post.php\">Create Post</a></li>
					<li><a href=\"#\">Edit Posts</a></li>
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

function test_email($email)
{
	$match_pattern = '/^[a-zA-Z]*[a-zA-Z]*@[a-zA-Z]*[a-zA-Z]*.nl$/';
	$match = preg_match($match_pattern, $email);

	if ($match) {
		$explode_result = explode("@", $email);
		$explode_result_domain = explode(".", $explode_result[1]);
		$name = $explode_result[0];
		$domain =$explode_result_domain[0];

		if (strlen($name) < 2 || strlen($domain) < 2) {
			return "invalid";
		} elseif ($name == 'admin' || $domain == 'admin') {
			return "invalid";
		}
	} else {
		return "invalid";
	}
}

//Eigen error handler
function error_msg($err_type, $err_msg, $err_file, $err_line){
	echo "<div class = 'errorMsg'>";
	echo "<p><b>Error:</b> Oops something went wrong! Please try again later or send an e-mail to admin@admin.nl <br />";
	echo "Error type: $err_type: $err_msg in $err_file at line $err_line";
	echo "</div>";

}

//Retrieve bloggers
function get_bloggers($connect) {
	$query = "SELECT name, ln_prefix, surname FROM users WHERE name != 'Admin'";
	$queryResult = mysqli_query($connect, $query);
	$numRows = mysqli_num_rows($queryResult);
	
	if($numRows > 0) {
		while($bloggers = mysqli_fetch_assoc($queryResult)){
			echo "<li><a href=?name=". $bloggers['name'] . ">". $bloggers['name'] . " " . stripslashes($bloggers['ln_prefix']) . " " . $bloggers['surname'] ."</a></li>";
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
