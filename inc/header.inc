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
                <h1>The header</h1>
            </div>
		<?php get_navbar();?>
		</div>
