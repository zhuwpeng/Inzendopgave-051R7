<?php 
include "/inc/functions.php";
include "db_connect.php";
session_start();

$message = "";
$errorMsg = "";
$usernameError = "";
$passwordError = "";
$error = false;

if (isset($_POST['submit']) && $_POST['submit'] == 'Login') {
	//Clear spaces and remove slashes
	$username = stripslashes(trim($_POST['username']));
	$password = stripslashes(trim($_POST['password']));
	
	//Check if inputfields are empty
	if (!empty($username) && !empty($password)) {
		//Check if user exist in database
		$userQuery = "SELECT user_id, username, password FROM users WHERE username = '$username';";
		$userResult = mysqli_query($connect, $userQuery) or die("Er is iets fout gegaan tijdens het ophalen van gegevens: " . mysqli_error($connect)) . ".";
		$userRows = mysqli_num_rows($userResult);
		
		//Check if only one user exist
		if ($userRows > 1) {
			$message = "Er zijn meerdere gebruikers gevonden met de zelfde gebruikersnaam. Controleer de database.";
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
		
		if (empty($username)) {
			$usernameError = "Fill in your username!";
		}
		
		if (empty($password)) {
			$passwordError = "Fill in your password!";
		}
	}
	
}
?>

<?php 
get_header();
?>
<div class="wrapper">
	<span><?php echo $message;?></span>
<span class=error><?php echo $errorMsg;?></span>
	<div class="form login">
		<h2>Aanmeld formulier</h2>
		<form method="POST" action="login.php">	
			<span class = error><?php echo $usernameError;?></span>
			<label for="form-username">Username:</label>
			<input type="text" id="form-username" name="username" value="<?php if(isset($_POST['username'])){echo htmlentities($_POST['username']);}else{ echo "";}?>">
			
			<span class = error><?php echo $passwordError;?></span>
			<label for="form-password">Password:</label>
			<input type="password" id="form-password" name="password" value="<?php if(isset($_POST['password'])){ echo htmlentities($_POST['password']);}else{ echo "";}?>">
			
			<input class="btn" type="submit" name="submit" value="Login">
		</form>
	</div>
</div>

<?php 
get_footer();
?>