<?php
include "functions.inc";
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
        <div class="header">
            <div class="logo">
            	<a href="index.php" ><img alt="logo" src="img/blogger_logo.png"></a>
            </div>
		<?php get_navbar();?>
		</div>
