<?php
include_once 'inc/header.inc';

$message = "";
$errorMsg = "";
$titleError ="";
$blogpostError = "";

$errors = array("empty" => array("title" => "You have to give your post a title.",
								"blogpost" => "Please write something in your blogpost."));

if (isset($_POST['submit']) && $_POST['submit'] == 'Create post') {
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
		$author = $_SESSION['user_id'];
		$title = mysqli_real_escape_string($connect, $stripTrim['title']);
		$content = mysqli_real_escape_string($connect, $stripTrim['blogpost']);
		$date = date('Y-m-d H:i:s');
		
		$insertQuery = "INSERT INTO posts (post_id,
										post_author,
										post_title,
										post_content,
										post_date)
								VALUES (NULL,
										'$author',
										'$title',
										'$content',
										'$date')";
		
		$insertResult = mysqli_query($connect, $insertQuery);
		
		if (mysqli_affected_rows($connect) == 1) {
			$message = "Your blogpost has been created!";
		}
	}
	
}

?>
<div class="wrapper">
<span class="message"><?php echo $message;?></span>
<span class=error><?php echo $errorMsg;?></span>
	<?php if (isset($_SESSION['user_id'])) {?>
	<div class="form post">
		<h2>Login</h2>
		<form method="POST" action="post.php">	
			<span class = error><?php if(isset($error['title'])) { echo $error['title'];}?></span>
			<label for="form-title">Title:</label>
			<input type="text" id="form-title" name="title" value="<?php if(isset($_POST['email'])){echo htmlentities($_POST['email']);}else{ echo "";}?>">
			
			<span class = error><?php if(isset($error['blogpost'])){echo $error['blogpost'];}?></span>
			<label for="form-blogpost">Blog post:</label>
			<textarea rows="5" cols="50" name="blogpost"><?php if(isset($_POST['boodschap'])){ echo htmlentities($_POST['boodschap']);}else{ echo "";}?></textarea>
			
			<input class="btn" type="submit" name="submit" value="Create post">
		</form>
	</div>
	<?php } else {?>
	<span class="message">You have to be logged in in order to create a post!</span>
	<?php }?>
</div>
<?php 
include_once 'inc/footer.inc';
?>