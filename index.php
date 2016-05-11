<?php
include_once 'inc/header.inc';
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
            		$userQuery = "SELECT name, ln_prefix, surname, reg_date FROM users WHERE user_id='" . $_SESSION['user_id'] . "'";
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
            if (isset($_GET['name'])){
            	$bloggerName = $_GET['name'];
            	//Retrieve posts made by the blogger and blogger data
            	$bloggerdataQuery = "SELECT user_id, ln_prefix, surname FROM users WHERE name ='$bloggerName'";
            	$bloggerdataResult = mysqli_query($connect, $bloggerdataQuery) or die("Could not retrieve information. " . mysqli_error($connect));
            	
            	if (mysqli_num_rows($bloggerdataResult) == 1) {
            		$bloggerData = mysqli_fetch_assoc($bloggerdataResult);
            		$bloggerID = $bloggerData['user_id'];
            		$bloggerPref = $bloggerData['ln_prefix'];
            		$bloggerSur = $bloggerData['surname'];
            	}
            	
            	$blogpostQuery = "SELECT post_author, post_title, post_content, post_date FROM posts WHERE post_author ='$bloggerID' ORDER BY post_date DESC";
            	$blogpostResult = mysqli_query($connect, $blogpostQuery) or die("Could not retrieve information. " . mysqli_error($connect));
            	
            	if (mysqli_num_rows($blogpostResult) > 0) {
            		while ($blogpost = mysqli_fetch_assoc($blogpostResult)){
            			$title = $blogpost['post_title'];
            			$content = nl2br($blogpost['post_content']);
            			$postDate = $blogpost['post_date'];
            			
            			echo "<div style='padding-bottom:20px;'>
		            			<div style='border-bottom:1px solid #d3d3d3;'>
		            			By <b>$bloggerName $bloggerPref $bloggerSur</b> - Title: <b>$title</b> - $postDate
		            			</div>
		            			<div style=' border-bottom: 1px solid black; padding:20px; '>
		            			$content
		            			</div>
		            		</div>";
            		}
            	} else {
            		echo "<h2>This user hasn't posted anything yet!</h2>";
            	}
            	
            } elseif (isset($_GET['page']) && $_GET['page']=="editposts") {
            	
            	
            ?>
            	
            <?php 
            }else{
            ?>
                <h2>Welcome to Bloggers</h2>
                <p>
                    Bloggers is a website where everyone can register and create blogposts.
                    It is a realy basic and easy to use website where people can write everything they want.
                </p>
                <p>
                    All you have to do is register an account by clicking on "Register" on the right side of the menu. Once you have registered your account you can login and start posting whatever comes to your mind or manage your earlier blogposts.
                    On the left side you can see all the bloggers that are creating content on Blogger including you! When you click on any of them, their blogposts will show up in this space replacing the text you are currently reading.
                </p>
            <?php 
            }
            ?>
            </div>
        </div>
<?php 
include_once 'inc/footer.inc';
?>