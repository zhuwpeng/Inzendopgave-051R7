<?php
include "inc/functions.inc.php";
include "db_connect.php";
session_start();
set_error_handler('error_msg');

$message = "";
$emailError = "";
$passwordError = "";
$error = false;

if (isset($_POST['submit']) && $_POST['submit'] == 'Login') {
	//Clear spaces and remove slashes
	$email = stripslashes(trim($_POST['email']));
	$password = stripslashes(trim($_POST['password']));

	//Validate input
	if (empty($email)) {
		$usernameError = "Fill in your e-mail!";
		$error = true;
	} else {
		if(test_email($email, $_POST['submit']) == false) {
			$emailError = "Invalid e-mail entered";
			$error = true;
		}
	}

	if (empty($password)) {
		$passwordError = "Fill in your password!";
		$error = true;
	}

	//Check if inputfields are empty
	if ($error == false) {
		//Check if user exist in database
		$email = mysqli_real_escape_string($connect, $email);
		$userQuery = "SELECT user_id, email, password FROM users WHERE email = '$email';";
		$userResult = mysqli_query($connect, $userQuery) or die("Could not retrieve data from the database. " . mysqli_error($connect)) . ".";
		$userRows = mysqli_num_rows($userResult);

		//Check if only one user exist
		if ($userRows > 1) {
			$message = "There are multiple users found with the same e-mail. Please check the database.";
		} elseif($userRows == 0) {
			$message = "Invalid username or password!";
		} else {
			//Retrieve data in an associative array
			$userdata = mysqli_fetch_assoc($userResult);
			//Compare password
			if (md5($password) === $userdata['password']){
				$_SESSION['user_id']=$userdata['user_id'];
				header("Location: index.php");
			}
		}
	}
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
				<span class="message"><?php echo $message;?></span>
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
		</div>
		<?php 
		include_once 'inc/footer.inc.php';
		?>
    </div>
</body>
</html>