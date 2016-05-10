<?php
include "db_connect.php";

// $errors = array('empty' => array('name' => "No name filled in!",
// 		'surname' => "No surname filled in!",
// 		'email' => "No e-mail filled in!",
// 		'password' => "No password filled in!",
// 		'confpassword' => "Need password confirmation!"),
// 		'invalid' => array('email' => "E-mail must be as follows: '3 character @ 2 characters .nl' (abc@de.nl)",
// 				'confpassword' => "Passwords do not match!")
// );

// $error = array('name' => "",
// 		'surname' => "",
// 		'email' => "",
// 		'password' => "",
// 		'confpassword' => "",
// );

// $_POST = array('name' => "drder",
// 		'lnprefix' => "",
// 		'surname' => "",
// 		'email' => "",
// 		'password' => "",
// 		'confpassword' => "",
// );

// //Stripslashes and trim input
// foreach ($_POST as $key => $input) {
// 	$stripTrim[$key] = stripslashes(trim($input));
// }

// //Check if filled in
// foreach ($stripTrim as $key => $input) {
// 	if ($key != "lnprefix") {
// 		if (empty($input)) {
// 			$error[$key] = $errors['empty'][$key];
// 		} else {
// 			$error[$key] = "";
// 		}
// 	}
// }

// echo $error['name'];

$name = 'test';
$list = "";

//email test
$email = 'test@teste.nl';
$match_pattern = '/^[a-zA-Z]*[a-zA-Z]*@[a-zA-Z]*[a-zA-Z]*.nl$/';
$match = preg_match($match_pattern, $email);

if($match){
	$explode_result = explode("@", $email);
	$explode_result_domain = explode(".", $explode_result[1]);
	$name = $explode_result[0];
	$domain = $explode_result_domain[0];
	
	echo "$name <br />";
	echo "$domain <br />";
}
//$query = "SELECT name, ln_prefix, surname FROM users WHERE name != 'Admin'";
$query = "SELECT name, ln_prefix, surname FROM users";
$queryResult = mysqli_query($connect, $query);
$numRows = mysqli_num_rows($queryResult);

if($numRows > 0) {
	while($bloggers = mysqli_fetch_assoc($queryResult)){
		//$list.= "<li>". ucfirst($bloggers['name']) . " " . (isset($bloggers['ln_prefix']) ? ucfirst(stripslashes($bloggers['ln_prefix'])): '') . " " .ucfirst($bloggers['surname']) ."</li>";
		$list.= "<li><a href=#>". $bloggers['name'] . " " . stripslashes($bloggers['ln_prefix']) . " " . $bloggers['surname'] ."</a></li>";
	}
} else {
	echo "No bloggers registered";
}

?>

<!DOCTYPE HTML>
<HTML>
<HEAD>
<TITLE></TITLE>
</HEAD>
<BODY>
<a href=test.php/?name=<?php echo $name?>><?php echo $name?></a>
<br />
<?php 

if (isset($_GET['name']) && $_GET['name']=='test') {
	echo "These are " . $_GET['name'] ."'s blog post.";
	}
?>
<ul>
<?php 
echo $list;
?>
</ul>

</BODY>
</HTML>