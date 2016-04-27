<?php 
include "/inc/functions.php";
include "db_connect.php";

$message = "";
$errorMsg = "";
$nameError = "";
$lnPrefixError = "";
$surnameError = "";
$emailError = "";
$passwordError = "";

$error = array('name' => "",
			'surname' => "",
			'email' => "",
			'password' => "",
			'confpassword' => "",
);

$errortype = array('empty' => array('name' => "No name filled in!",
								'surname' => "No surname filled in!",
								'username' => "No username filled in!",
								'email' => "No e-mail filled in!",
								'password' => "No password filled in!",
								'confpassword' => "Need password confirmation!"),
				'invalid' => array('email' => "E-mail must be as follows: '2 characters @ 2 characters .nl' (abc@de.nl)",
								'confpassword' => "Passwords do not match!")
);
								
if (isset($_POST['submit']) && $_POST['submit'] == 'Submit') {
	//Stripslashes and trim input while leaving out $_POST['submit']
	foreach ($_POST as $key => $input) {
		if ($key != "submit")
		$stripTrim[$key] = stripslashes(trim($input));
	}
	
	//Check if fields are filled in
	foreach ($stripTrim as $key => $input) {
		if (empty($input)) {
			if ($key == "ln_prefix") {
				$stripTrim[$key] = NULL;
			} else {
			$error[$key] = $errortype['empty'][$key];
			}
		} else {
			$error[$key] = "";
		}
	}
	
	//Validate email
	if (empty($error['email'])) {
		if(test_email($stripTrim['email']) == "invalid") {
			$error['email']= $errortype['invalid']['email'];
		}
	}
	
	if (empty($error['confpassword'])) {
		if ($stripTrim['confpassword'] != $stripTrim['password']) {
			$error['confpassword']= $errortype['invalid']['confpassword'];
		}
	}
	
	$error = array_filter($error);
	
	if(empty($error)) {
		//Escape all input values
		foreach($stripTrim as $key => $input) {
			if ($key != "confpassword") {
				$escInput[$key] = mysqli_real_escape_string($connect, $input);
			}
		}
		
		$name = $escInput['name'];
		$ln_prefix = $escInput['ln_prefix'];
		$surname = $escInput['surname'];
		$username = $escInput['username'];
		$email = $escInput['email'];
		$password = md5($escInput['password']);
		
		//Insert input into database
		$inputQuery = "INSERT INTO users (user_id,
											name,
											ln_prefix,
											surname,
											username,
											email,
											password,
											usertype)
									VALUES (NULL,
											'$name',
											'$ln_prefix',
											'$surname',
											'$username',
											'$email',
											'$password',
											'member')";
		$resultQuery = mysqli_query($connect, $inputQuery);
		
		if (mysqli_affected_rows($connect) == 1) {
			$message = "Uw account is met success aangemaakt!";
			unset($_POST);
		}
	}
	
}

if(isset($_POST['reset']) && $_POST['reset'] == "Reset"){
	unset($_POST);
}

?>

<?php 
get_header();
?>

<div class="wrapper">
	<span class="message"><?php echo $message;?></span>
<span class=error><?php echo $errorMsg;?></span>
	<div class="form register">
		<h2>Aanmeld formulier</h2>
		<form method="POST" action="register.php">	
			<span class="error"><?php if(isset($error['name'])) {echo $error['name'];}?></span>
			<label for="form-name">Name:</label>
			<input type="text" id="form-name" name="name" value="<?php if(isset($_POST['name'])){echo htmlentities($_POST['name']);}else{ echo "";}?>">
			
			<label for="form-lnprefix">Last name prefix:</label>
			<input type="text" id="form-lnprefix" name="ln_prefix" value="<?php if(isset($_POST['ln_prefix'])){echo htmlentities($_POST['ln_prefix']);}else{ echo "";}?>">

			<span class="error"><?php if(isset($error['surname'])) {echo $error['surname'];}?></span>
			<label for="form-surname">Surname:</label>
			<input type="text" id="form-surname" name="surname" value="<?php if(isset($_POST['surname'])){echo htmlentities($_POST['surname']);}else{ echo "";}?>">
			
			<span class="error"><?php if(isset($error['username'])) {echo $error['username'];}?></span>
			<label for="form-username">Username:</label>
			<input type="text" id="form-username" name="username" value="<?php if(isset($_POST['username'])){echo htmlentities($_POST['username']);}else{ echo "";}?>">

			<span class="error"><?php if(isset($error['email'])) {echo $error['email'];}?></span>
			<label for="form-email">E-mail:</label>
			<input type="text" id="form-email" name="email" value="<?php if(isset($_POST['email'])){echo htmlentities($_POST['email']);}else{ echo "";}?>">
			
			<span class="error"><?php if(isset($error['password'])) {echo $error['password'];}?></span>
			<label for="form-password">Password:</label>
			<input type="password" id="form-password" name="password" value="<?php if(isset($_POST['password'])){ echo htmlentities($_POST['password']);}else{ echo "";}?>">
			
			<span class="error"><?php if(isset($error['confpassword'])) {echo $error['confpassword'];}?></span>
			<label for="form-confpassword">Confirm password:</label>
			<input type="password" id="form-confpassword" name="confpassword" value="<?php if(isset($_POST['confpassword'])){ echo htmlentities($_POST['confpassword']);}else{ echo "";}?>">
			
			<div class="submit_reset">
				<input class="btn" type="submit" name="submit" value="Submit">
				<input class="btn" type="submit" name="reset" value="Reset">
	        </div>
		</form>
	</div>
</div>

<?php 
get_footer();
?>