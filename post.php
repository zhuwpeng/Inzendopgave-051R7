<?php
include_once 'inc/header.inc';

$message = "";
$errorMsg = "";
$titleError ="";
$blogpostError = "";

if(isset($_POST['submit']) && $_POST['submit']=="Create new post") {
	$title = stripslashes(trim($_POST['title']));
	
	//Check if empty
	if(!empty($title)){
		
	}
}

?>
<div class="wrapper">
<span class="message"><?php echo $message;?></span>
<span class=error><?php echo $errorMsg;?></span>
	<div class="form post">
		<h2>Create a new blog post</h2>
		<form method="POST" action="post.php">	
			<span class = error><?php echo $titleError;?></span>
			<label for="form-title">Title:</label>
			<input type="text" id="form-title" name="title" value="<?php if(isset($_POST['email'])){echo htmlentities($_POST['email']);}else{ echo "";}?>">
			
			<span class = error><?php echo $blogpostError;?></span>
			<label for="form-blogpost">Blog post:</label>
			<textarea rows="10" cols="57" name="blogpost"><?php if(isset($_POST['boodschap'])){ echo htmlentities($_POST['boodschap']);}else{ echo "";}?></textarea>
			
			<input class="btn" type="submit" name="submit" value="Create new post">
		</form>
	</div>
</div>
<?php 
include_once 'inc/footer.inc';
?>