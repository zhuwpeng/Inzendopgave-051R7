<?php
// Connection information
$user = "user";
$password = "password";
$host = "localhost";

// Connect to database
$connect = mysqli_connect($host, $user, $password)
    or die("Could not connect to the database. " . mysqli_error($connect));

function make_table($connect, $tableparameters, $tablename)
{
    // Test if table exist
    $testquery = "SELECT 1 FROM $tablename";
    
    if (!mysqli_query($connect, $testquery)) {
        // Create the table
        $tablequery = "CREATE TABLE $tablename ($tableparameters);";
        mysqli_query($connect, $tablequery);
        
        // Check if the table has been created
        if (mysqli_query($connect, "SELECT 1 FROM $tablename")) {
            echo "Table '$tablename' has successfully been created in database 'dbloi'!<br />";
        } else {
            echo "Please check your query for any mistakes.<br />";
        }
    } else {
        echo "The table '$tablename' already exists!<br />";
    }
}

$usersTable = "users";
$usersQuery = "user_id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(64) NOT NULL,
                ln_prefix VARCHAR(64),
                surname VARCHAR(64) NOT NULL,
                email VARCHAR(64) NOT NULL,
                password VARCHAR(64) NOT NULL,
                usertype CHAR(20) NOT NULL,
				reg_date DATE NOT NULL";

$blogTable = "posts";
$blogQuery = "post_id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                user_id BIGINT NOT NULL,
                title TEXT NOT NULL,
                content LONGTEXT NOT NULL,
                date DATETIME,
				edited BOOLEAN NULL";

// Check if database exist
if (!mysqli_select_db($connect, 'dbloi')) {
    // Create database
    mysqli_query($connect, "CREATE DATABASE dbloi;");
    
    echo "Database 'dbloi' has been created. <br />";
    
    if (mysqli_select_db($connect, 'dbloi')) {
        // Create tables
        make_table($connect, $usersQuery, $usersTable);
        make_table($connect, $blogQuery, $blogTable);
    }
} else {
    // Create tables
    make_table($connect, $usersQuery, $usersTable);
    make_table($connect, $blogQuery, $blogTable);
    
}
