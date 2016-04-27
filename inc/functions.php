<?php 

function get_header()
{
echo
"<!DOCTYPE html>
<html>

<head>
    <meta charset=\"utf-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <meta name=\"description\" content=\"\">
    <meta name=\"author\" content=\"\">
    <link rel=\"stylesheet\" type=\"text/css\" href=\"css/style.css\">

    <title>Inzendopgave 051R7</title>

</head>
<body>
    <div id=\"container\">
        <div class=\"header\">
            <div class=\"logo\">
                <h1>The header</h1>
            </div>";
			get_navbar();
       echo "</div>";
}

function get_navbar() {
	//Check if any user_id has been set in session
	if (isset($_SESSION['user_id'])) {
		echo "<div class=\"navbar-wrap\">
					<ul class=\"nav\">
					<li><a href=\"index.php\">Home</a></li>
					<li><a href=#>About</a></li>
					<li><a href=#>Contact</a></li>
					<li class=\"nav-login\"><a href=\"logout.php\">Logout</a></li>
					<li class=\"nav-login\"><a href=\"#\">Edit Posts</a></li>
					</ul>
				</div>";
	} else {
		echo "<div class=\"navbar-wrap\">
					<ul class=\"nav\">
					<li><a href=\"index.php\">Home</a></li>
					<li><a href=#>About</a></li>
					<li><a href=#>Contact</a></li>
					<li class=\"nav-login\"><a href=\"login.php\">Login</a></li>
					<li class=\"nav-login\"><a href=\"register.php\">Register</a></li>
					</ul>
				</div>";
	}
}


function get_footer() {
	echo "        <div class=\"footer\">
            <h2>This is the footer</h2>
        </div>
    </div>
</body>
</html>";
}


function test_email($email)
{
	$match_pattern = '/^[a-zA-Z]*[a-zA-Z]*@[a-zA-Z]*[a-zA-Z]*.nl$/';
	$match = preg_match($match_pattern, $email);

	if($match){
		$explode_result = explode("@", $email);
		$explode_result_domain = explode(".", $explode_result[1]);
		$name = $explode_result[0];
		$domain =$explode_result_domain[0];

		if(strlen($name) < 2 || strlen($domain) < 2){
			return "invalid";
		}
	}else{
		return "invalid";
	}
}