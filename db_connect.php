<?php
// Connection information
$user = "user";
$password = "password";
$host = "localhost";
$db = "dbloi";

// Connect to database
$connect = mysqli_connect($host, $user, $password, $db) or die("Cannot connect to the database." . mysqli_error($connect));
