<?php 
include_once 'inc/header.inc';

$message = "";
$nameError = "";
$lnPrefixError = "";
$surnameError = "";
$emailError = "";
$passwordError = "";

$error = array('name' => "",
			'surname' => "",
			'email' => ""
);

$errortype = array('empty' => array('name' => "No name filled in!",
								'surname' => "No surname filled in!",
								'email' => "No e-mail filled in!"),
				'invalid' => array('email' => "E-mail must not contain 'admin' and should be as follows: '2 characters @ 2 characters .nl' (ab@cd.nl)",
								'emailexist' => "E-mail already exist!")
);
								
if (isset($_POST['submit']) && $_POST['submit'] == 'Register') {
	//Stripslashes and trim input while leaving out $_POST['submit']
	foreach ($_POST as $key => $input) {
		if ($key != "submit") {
			$stripTrim[$key] = stripslashes(trim($input));
		}
	}
	
	//Check if userinputs are empty
	foreach ($stripTrim as $key => $input){
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
	
	if (empty($error['email'])) {
		//Validate email
		if (test_email($stripTrim['email'], $_POST['submit'])== false) {
			$error['email']= $errortype['invalid']['email'];
		} else {
			//Check if e-mail exist
			$emailQuery = "SELECT email FROM users WHERE email='" . $stripTrim['email'] . "'";
			$emailResult = mysqli_query($connect, $emailQuery) or die("Could not retrieve data from the database. " . mysqli_error($connect));

			if (mysqli_num_rows($emailResult)!=0) {
				$error['email'] = $errortype['invalid']['emailexist'];
			}
		}
	}	
	
	$error = array_filter($error);
	
	if(empty($error)) {
		//Escape all input values
		foreach($stripTrim as $key => $input) {
			$escInput[$key] = mysqli_real_escape_string($connect, $input);
		}
		
		$name = ucfirst($escInput['name']);
		$ln_prefix = $escInput['ln_prefix'];
		$surname = ucfirst($escInput['surname']);
		$email = $escInput['email'];
		$password = random_password();
		$passencrypt = md5($password);
		$reg_date = date('Y-m-d');
		
		//Insert input into database
		$inputQuery = "INSERT INTO users (user_id,
											name,
											ln_prefix,
											surname,
											email,
											password,
											usertype,
											reg_date)
									VALUES (NULL,
											'$name',
											'$ln_prefix',
											'$surname',
											'$email',
											'$passencrypt',
											'member',
											'$reg_date')";
		$resultQuery = mysqli_query($connect, $inputQuery) or die("Could insert data into the database. " . mysqli_error($connect));
		
		if (mysqli_affected_rows($connect) == 1) {
			$confirmation = (mail($email, "Registratie",
"Welcome to Bloggers!\r\n
This is a confirmation e-mail from your registration.\r\n
Below are your username and password. Keep them somewhere safe\r\n
and never share your password to anyone!\r\n
Username: $email\r\n
Password: $password\r\n
\r\n
Thank you for your registration and have fun blogging!\r\n",
"Van: info@bloggers.nl"));
			
			if ($confirmation) {
				$message = "Your account has been succesfully created! Your password will be sent to your mailbox shortly!";
				unset($_POST);
			}
		}
	}
}

if(isset($_POST['reset']) && $_POST['reset'] == "Reset"){
	unset($_POST);
}

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
		<span class="message"><?php echo $message;?></span>
		<div class="form register">
			<h2>Register</h2>
			<form method="POST" action="register.php">	
				<span class="error"><?php if(isset($error['name'])) {echo $error['name'];}?></span>
				<label for="form-name">First name:</label>
				<input type="text" id="form-name" name="name" value="<?php if(isset($_POST['name'])){echo htmlentities($_POST['name']);}else{ echo "";}?>">
				
				<span class="error"><?php if(isset($error['surname'])) {echo $error['surname'];}?></span>
				<label for="form-surname">Last name:</label>
				<input type="text" id="form-surname" name="surname" value="<?php if(isset($_POST['surname'])){echo htmlentities($_POST['surname']);}else{ echo "";}?>">
				
				<label for="form-lnprefix">Last name prefix:</label>
				<input type="text" id="form-lnprefix" name="ln_prefix" value="<?php if(isset($_POST['ln_prefix'])){echo htmlentities($_POST['ln_prefix']);}else{ echo "";}?>">
				
				<span class="error"><?php if(isset($error['email'])) {echo $error['email'];}?></span>
				<label for="form-email">E-mail:</label>
				<input type="text" id="form-email" name="email" value="<?php if(isset($_POST['email'])){echo htmlentities($_POST['email']);}else{ echo "";}?>">
				
				<div class="submit_reset">
					<input class="btn" type="submit" name="submit" value="Register">
					<input class="btn" type="submit" name="reset" value="Reset">
		        </div>
			</form>
		</div>
	</div>
</div>
<?php 
include_once 'inc/footer.inc';
?>