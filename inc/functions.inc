<?php 
function get_navbar() {
	//Check if any user_id has been set in session
	if (isset($_SESSION['user_id'])) {
		echo "<div class=\"navbar-wrap\">
					<ul class=\"nav\">
					<li><a href=\"index.php\">Home</a></li>
					<li class=\"nav-login\"><a href=\"logout.php\">Logout</a></li>
					<li class=\"nav-login\"><a href=\"#\">Edit Posts</a></li>
					</ul>
				</div>";
	} else {
		echo "<div class=\"navbar-wrap\">
					<ul class=\"nav\">
					<li><a href=\"index.php\">Home</a></li>
					<li class=\"nav-login\"><a href=\"login.php\">Login</a></li>
					<li class=\"nav-login\"><a href=\"register.php\">Register</a></li>
					</ul>
				</div>";
	}
}

function test_email($email)
{
	$match_pattern = '/^[a-zA-Z]*[a-zA-Z]*@[a-zA-Z]*[a-zA-Z]*.nl$/';
	$match = preg_match($match_pattern, $email);

	if ($match) {
		$explode_result = explode("@", $email);
		$explode_result_domain = explode(".", $explode_result[1]);
		$name = $explode_result[0];
		$domain =$explode_result_domain[0];

		if (strlen($name) < 2 || strlen($domain) < 2) {
			return "invalid";
		} elseif ($name == 'admin' || $domain == 'admin') {
			return "invalid";
		}
	} else {
		return "invalid";
	}
}

//Eigen error handler
function error_msg($err_type, $err_msg, $err_file, $err_line){
	echo "<div class = 'errorMsg'>";
	echo "<p><b>Error:</b> Oops something went wrong! Please try again later or send an e-mail to admin@admin.nl <br />";
	echo "Error type: $err_type: $err_msg in $err_file at line $err_line";
	echo "</div>";

}