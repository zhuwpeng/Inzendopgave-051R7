<?php 
include "/inc/functions.php";

$message = "";
$errorMsg = "";
$nameError = "";
$lnPrefixError = "";
$surnameError = "";
$emailError = "";
$error = false;

?>

<?php 
get_header();
?>
<div class="wrapper">
	<span><?php echo $message;?></span>
<span class=error><?php echo $errorMsg;?></span>
	<div class="register-form">
		<h2>Aanmeld formulier</h2>
		<form method="POST" action="register.php">	
			<span class = error><?php echo $nameError;?></span>
			<label for="form-name">Name:</label>
			<input type="text" id="form-name" name="name" value="<?php if($error){echo htmlentities($_POST['name']);}else{ echo "";}?>">
			
			<span class = error><?php echo $lnPrefixError;?></span>
			<label for="form-lnprefix">Last name prefix:</label>
			<input type="text" id="form-lnprefix" name="lnprefix" value="<?php if($error){echo htmlentities($_POST['lnprefix']);}else{ echo "";}?>">

			<span class = error><?php echo $surnameError;?></span>
			<label for="form-surname">Surname:</label>
			<input type="text" id="form-surname" name="surname" value="<?php if($error){echo htmlentities($_POST['surname']);}else{ echo "";}?>">

			<span class = error><?php echo $emailError;?></span>
			<label for="form-email">E-mail:</label>
			<input type="text" id="form-email" name="email" value="<?php if($error){echo htmlentities($_POST['email']);}else{ echo "";}?>">
			
			<input type="submit" name="submit" value="Register">
			<input type="submit" name="reset" value="Clear">
		</form>
	</div>
</div>

<?php 
get_footer();
?>