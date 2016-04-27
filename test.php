<?php
$errors = array('empty' => array('name' => "No name filled in!",
		'surname' => "No surname filled in!",
		'email' => "No e-mail filled in!",
		'password' => "No password filled in!",
		'confpassword' => "Need password confirmation!"),
		'invalid' => array('email' => "E-mail must be as follows: '3 character @ 2 characters .nl' (abc@de.nl)",
				'confpassword' => "Passwords do not match!")
);

$error = array('name' => "",
		'surname' => "",
		'email' => "",
		'password' => "",
		'confpassword' => "",
);

$_POST = array('name' => "drder",
		'lnprefix' => "",
		'surname' => "",
		'email' => "",
		'password' => "",
		'confpassword' => "",
);

//Stripslashes and trim input
foreach ($_POST as $key => $input) {
	$stripTrim[$key] = stripslashes(trim($input));
}

//Check if filled in
foreach ($stripTrim as $key => $input) {
	if ($key != "lnprefix") {
		if (empty($input)) {
			$error[$key] = $errors['empty'][$key];
		} else {
			$error[$key] = "";
		}
	}
}

echo $error['name'];