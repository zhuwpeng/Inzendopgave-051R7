<?php
// Connection information
$user = "user";
$password = "password";
$host = "localhost";
$db = "dbloi";

// Connect to database
$connect = mysqli_connect($host, $user, $password, $db)
    or die("Kan geen verbinding maken met de database. Contrleer uw verbinding of uw database.");
