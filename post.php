<?php
session_start();
include "inc/functions.inc.php";
include "db_connect.php";
set_error_handler('error_msg');

$message = "";

$errors = array("empty" => array("title" => "You have to give your post a title.",
		"blogpost" => "Please write something in your blogpost."));

if (isset($_POST['submit'])) {
	//Strip slashes and trim input before checking if empty while leaving out $_POST['submit']
	foreach($_POST as $key => $input) {
		if ($key!="submit") {
			$stripTrim[$key] = stripslashes(trim($input));
		}
	}

	//Check if userinputs are empty
	foreach($stripTrim as $key => $input) {
		if(empty($input)){
			$error[$key] = $errors['empty'][$key];
		} else {
			$error[$key] = "";
		}
	}

	$error = array_filter($error);

	if (empty($error)) {
		if ($_POST['submit'] == 'Create post'){
			if (create_post($connect, NULL, $_SESSION['user_id'], $stripTrim['title'], $stripTrim['blogpost'], False)) {
				unset($_POST);
				header("Location: index.php?page=editposts");
				exit();
			}
		} elseif ($_POST['submit'] == 'Edit post') {
				
			if(create_post($connect, $_POST['postID'], $_SESSION['user_id'], $stripTrim['title'], $stripTrim['blogpost'], True)) {
				unset($_POST);
				header("Location: index.php?page=editposts");
				exit();
			}
		}
	}
}

if (isset($_GET['editPID']) && isset($_SESSION['user_id'])) {
	$postID = $_GET['editPID'];

	//Retrieve post title and content
	$retrieveQuery = "SELECT * FROM posts WHERE post_id = $postID";
	$retrieveResult = mysqli_query($connect, $retrieveQuery) or die("Could not access the database " . mysqli_error($connect));

	if (mysqli_num_rows($retrieveResult) == 1) {
		$retrieveData = mysqli_fetch_assoc($retrieveResult);
		$postTitle = $retrieveData['title'];
		$postContent = $retrieveData['content'];
	}
}

if (isset($_POST['reset']) && $_POST['reset'] == "Clear") {
	unset($_POST);
}

if (isset($_POST['reset']) && $_POST['reset'] == "Undo changes"){
	header("Location: post.php?editPID=" . $_POST['postID'] ."");
	exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <title>Inzendopdracht 051R7</title>

</head>
<body>
    <div id="container">
		<?php
		include_once 'inc/header.inc.php';
		?>
		<div class="wrapper">
			<div class="side-wrapper">
				<div class="small-wrapper">
					<div class="panel-head">
						<h3>Bloggers</h3>
					</div>
					<div class="bloggers side-content">
						<ul>
						<?php
							get_bloggers($connect);
						?>
						</ul>
					</div>
				</div>
			</div>
			<div class="main-content">
			<?php if (isset($_SESSION['user_id'])) {?>
				<span class="message"><?php echo $message;?></span>
				<div class="form post">
					<h2>Your blogpost</h2>
					<form method="POST" action="post.php">	
						<span class = error><?php if(isset($error['title'])) { echo $error['title'];}?></span>
						<label for="form-title">Title:</label>
						<input type="text" id="form-title" name="title" value="<?php if(isset($_POST['title'])){echo htmlentities($_POST['title']);}elseif(isset($_GET['editPID'])){echo $postTitle;} else{ echo "";}?>">
						
						<span class = error><?php if(isset($error['blogpost'])){echo $error['blogpost'];}?></span>
						<label for="form-blogpost">Blog post:</label>
						<textarea rows="15" cols="50" name="blogpost"><?php if(isset($_POST['blogpost'])){ echo htmlentities($_POST['blogpost']);}elseif(isset($_GET['editPID'])){ echo $postContent; }else{ echo "";}?></textarea>
						<input type="hidden" name="postID" value="<?php if (isset($_GET['editPID'])){echo htmlspecialchars($_GET['editPID']);}else{ echo "";}?>">
						
						<input class="btn" type="submit" name="submit" <?php if (!isset($_GET['editPID'])){ echo "value=\"Create post\"";}else{echo "value=\"Edit post\"";}?>>
						<input class="btn" type="submit" name="reset" <?php if (!isset($_GET['editPID'])){ echo "value=\"Clear\"";}else{echo "value=\"Undo changes\"";}?>>
					</form>
				</div>
				<?php } else {?>
				<span class="message">You have to be logged in in order to create a post!</span>
			<?php }?>
			</div>
		</div>
		<?php 
		include_once 'inc/footer.inc.php';
		?>
    </div>
</body>
</html>