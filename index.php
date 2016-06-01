<?php
include "inc/functions.inc.php";
include "db_connect.php";
session_start();
set_error_handler('error_msg');
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
            	
            	<?php 
            	if (isset($_SESSION['user_id'])) {
            		echo '<div class="small-wrapper">
	            			<div class="panel-head">
	            				<h3>Welcome back!</h3>
	            			</div>';
            	
            		//Retrieve user information
            		$userQuery = "SELECT user_id, name, ln_prefix, surname, reg_date FROM users WHERE user_id='" . $_SESSION['user_id'] . "'";
            		$userResult = mysqli_query($connect, $userQuery) or die("Could not retrieve information. " . mysqli_error($connect));
            		$userData = mysqli_fetch_assoc($userResult);
            		
            		$name = $userData['name'];
            		$ln_prefix = $userData['ln_prefix'];
            		$surname = $userData['surname'];
            		$reg_date = $userData['reg_date'];
            		
            		$explode = explode("-", $reg_date);
            		$reorder = array($explode[2], $explode[1], $explode['0']);
            		$regisDate = implode("-", $reorder);
            		
            		echo '	<div class="user side-content">
	            				<p><label>Name: </label>' . $name . " " . $ln_prefix . " " . $surname . '<p>
			            		<p><label>Member since: </label> ' . $regisDate . '<p>
	            			</div>
	            		</div>';
	            	}
            	?>
            	
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
	            <?php 
	            if (isset($_GET['id'])){
	            	//Retrieve all the blogposts from any blogger in the list
	            	get_blogposts($_GET['id'], $connect, false);
	            } elseif (isset($_GET['page']) && $_GET['page']=="editposts" && isset($_SESSION['user_id'])) {
	            	?>
	            	<h2>Edit or remove blogposts</h2>
	            	<table class="table">
		            	<tr>
			            	<th>Title</th>
			            	<th>Date and time</th>
			            	<th></th>
			            	<th></th>
			            </tr>
	            <?php
	            	//Retrieve the blogposts from the currently logged in blogger
	            	get_blogposts($_SESSION['user_id'], $connect, true);
	            ?>
	            	</table>
	            <?php 
	            } elseif(isset($_GET['deletePID']) && isset($_SESSION['user_id'])) {
	            	//Delete the post that has been selected
	            	$postID = $_GET['deletePID'];
	            	$deleteQuery = "DELETE FROM posts WHERE post_id = $postID";
	            	$deleteResult = mysqli_query($connect, $deleteQuery) or die("could not connect to the database." . mysqli_error($connect));
	            	
	            	if (mysqli_affected_rows($connect)) {
	            		echo "<h2>The blogpost has been successfully removed!</h2>";
            			echo "Click <a href=\"index.php?page=editposts\">here</a> to go back to all your blogposts.";
	            	}
	            	
				} elseif(isset($_SESSION['user_id'])){
					if ($_SESSION['user_id'] == 1) {
						echo "<h2>These are all the user blogposts</h2>";
					} else {
						echo "<h2>Your blogposts</h2>";
					}
					//Retrieve the blogposts from the currently logged in blogger
					get_blogposts($_SESSION['user_id'], $connect, false);
				} else {
	            ?>
	                <h2>Welcome to Bloggers</h2>
	                <h3>You might want to read this first!</h3>
	                <p>
	                    Bloggers is a website where everyone can register and create blogposts.
	                    It is a really basic and easy to use website where people can write everything they want.
	                </p>
	                <p>
	                    All you have to do is register an account by clicking on "Register" on the right side of the menu.
	                    After you have registered your account you will receive your password via e-mail. Once you have 
	                    received the e-mail you can login using your e-mail and password and start posting whatever comes 
	                    to your mind or manage your earlier blogposts if you have any!
	                </p>
	                <p>
	                    On the left side you can see all the bloggers that are creating content on Blogger including you! 
	                    When you click on any of them, their blogposts will show up in this space replacing the text you 
	                    are currently reading.
	                </p>
	            <?php 
	            }
	            ?>
            </div>
        </div>
		<?php 
		include_once 'inc/footer.inc.php';
		?>
    </div>
</body>
</html>