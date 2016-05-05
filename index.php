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
            	}
            			
            	if (isset($_SESSION['user_id'])) {
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
            		$date = implode("-", $reorder);
            		
            		echo '	<div class="user side-content">
	            				<p><label>Name: </label>' . $name . " " . $ln_prefix . " " . $surname . '<p>
			            		<p><label>Member since: </label> ' . $date . '<p>
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
	                        <li><a href='/ligretchen-lopez-li'>Gretchen Lopez</a></li>
	                        <li><a href='/lidorothy-mcbride-li'>Dorothy Mcbride</a></li>
	                        <li><a href='/lidianne-hamilton-li'>Dianne Hamilton</a></li>
	                        <li><a href='/lifrederick-wood-li'>Frederick Wood</a></li>
	                        <li><a href='/lialfred-byrd-li'>Alfred Byrd</a></li>
	                        <li><a href='/lityler-parks-li'>Tyer Parks</a></li>
	                        <li><a href='/litimmy-brooks-li'>Timmy Brooks</a></li>
	                        <li><a href='/lijeanne-pittman-li'>Jeanne Pittman</a></li>
	                        <li><a href='/lidexter-colon-li'>Dexter Colon</a></li>
	                        <li><a href='/licurtis-wright-li'>Curtis Wright</a></li>
	                    </ul>
	                </div>
                </div>
            </div>

            <div class="main-content">
                <h2>The main content</h2>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin eleifend metus et dui dictum rhoncus. In vel lacinia dui. Nulla hendrerit nibh eget turpis viverra, vitae eleifend sem dignissim. Ut id maximus nunc. Quisque placerat mi velit, vitae pellentesque tortor ultricies ac. Etiam sed mollis metus, vitae laoreet leo. Ut ultrices nulla est, ut bibendum nunc finibus vel. Mauris non aliquet urna. Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis in urna nec leo convallis ullamcorper. Ut quis tincidunt elit. Fusce sem ex, vulputate sed mollis id, efficitur sed velit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Ut bibendum ac nisl a porttitor. Mauris ut magna ligula.
                </p>
                <p>
                    Suspendisse hendrerit venenatis volutpat. Aenean nec dui vitae quam venenatis imperdiet. Donec rutrum leo at varius tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Ut lorem metus, efficitur vel dui ut, mattis venenatis metus. In turpis felis, sodales vitae porta vitae, posuere in purus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
                </p>
            </div>
        </div>
<?php 
include_once 'inc/footer.inc';
?>