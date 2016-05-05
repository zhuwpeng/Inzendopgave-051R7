<?php
include_once 'inc/header.inc';

$message = "";
$errorMsg = "";
$titleError ="";
$blogpostError = "";

if (isset($_POST['submit']) && $_POST['submit'] == 'Create post') {
	
}

?>
<div class="wrapper">
<span class="message"><?php echo $message;?></span>
<span class=error><?php echo $errorMsg;?></span>
	<?php if (isset($_SESSION['user_id'])) {
	
		?>
	<div class="form post">
		<h2>Login</h2>
		<form method="POST" action="post.php">	
			<span class = error><?php echo $titleError;?></span>
			<label for="form-title">Title:</label>
			<input type="text" id="form-title" name="text" value="<?php if(isset($_POST['email'])){echo htmlentities($_POST['email']);}else{ echo "";}?>">
			
			<span class = error><?php echo $blogpostError;?></span>
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