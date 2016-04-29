<?php 
include_once 'inc/header.inc';

$message = "";
$errorMsg = "";
$emailError = "";
$passwordError = "";
$error = false;

if (isset($_POST['submit']) && $_POST['submit'] == 'Login') {
	//Clear spaces and remove slashes
	$email = stripslashes(trim($_POST['email']));
	$password = stripslashes(trim($_POST['password']));
	
	//Check if inputfields are empty
	if (!empty($email) && !empty($password)) {
		//Check if user exist in database
		$email = mysqli_real_escape_string($connect, $email);
		$userQuery = "SELECT user_id, email, password FROM users WHERE email = '$email';";
		$userResult = mysqli_query($connect, $userQuery) or die("Er is iets fout gegaan tijdens het ophalen van gegevens: " . mysqli_error($connect)) . ".";
		$userRows = mysqli_num_rows($userResult);
		
		//Check if only one user exist
		if ($userRows > 1) {
			$message = "There are multiple users found with the same e-mail. Please check the database.";
		} else {
		//Retrieve data in an associative array
			$userdata = mysqli_fetch_assoc($userResult);
			//Compare password
			if (md5($password) === $userdata['password']){
				$_SESSION['user_id']=$userdata['user_id'];
				header("Location: index.php");
			}
		}
	} else {
		
		if (empty($email)) {
			$usernameError = "Fill in your username!";
		} else {
			if(test_email($email) == "invalid") {
				$emailError = "Invalid e-mail entered";
			}
		}
		
		if (empty($password)) {
			$passwordError = "Fill in your password!";
		}
	}
	
}
?>
<div class="wrapper">
<span class="message"><?php echo $message;?></span>
<span class=error><?php echo $errorMsg;?></span>
	<div class="form login">
		<h2>Login</h2>
		<form method="POST" action="login.php">	
			<span class = error><?php echo $emailError;?></span>
			<label for="form-username">E-mail:</label>
			<input type="text" id="form-username" name="email" value="<?php if(isset($_POST['email'])){echo htmlentities($_POST['email']);}else{ echo "";}?>">
			
			<span class = error><?php echo $passwordError;?></span>
			<label for="form-password">Password:</label>
			<input type="password" id="form-password" name="password" value="<?php if(isset($_POST['password'])){ echo htmlentities($_POST['password']);}else{ echo "";}?>">
			
			<input class="btn" type="submit" name="submit" value="Login">
		</form>
	</div>
</div>
<?php 
include_once 'inc/footer.inc';
?>