<?php

// Connection information
$user = "user";
$password = "password";
$host = "localhost";

// Connect to database
$connect = mysqli_connect($host, $user, $password)
    or die("Kan geen verbinding maken met de database. Contrleer uw verbinding of uw database.");

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
$usersQuery = "user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                name CHAR(30) NOT NULL,
                ln_prefix CHAR(20),
                surname CHAR(20) NOT NULL,
				username CHAR(30) NOT NULL,
                email CHAR(30) NOT NULL,
                password VARCHAR(64) NOT NULL,
                usertype CHAR(20) NOT NULL";

$blogTable = "posts";
$blogQuery = "post_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                post_author INT(20) NOT NULL,
                post_title TEXT NOT NULL,
                post_content LONGTEXT NOT NULL,
                post_date DATETIME";

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

$checkAdminQuery = "SELECT user_id FROM users WHERE name = 'Admin'";
$checkAdminResult = mysqli_query($connect, $checkAdminQuery);

if (mysqli_num_rows($checkAdminResult) == 0) {
    // Create administrator user
    
    $adminpass = md5('password');
    $adminQuery = "INSERT INTO users (user_id, name, surname, username, email, password, usertype) VALUES (NULL, 'Admin', 'Admin', 'Admin', 'admin@admin.com', '$adminpass', 'Admin')";
    mysqli_query($connect, $adminQuery);

    $checkAdminQuery = "SELECT user_id FROM users WHERE name = 'Admin'";
    $checkAdminResult = mysqli_query($connect, $checkAdminQuery);
    
    if (mysqli_num_rows($checkAdminResult) > 0) {
        echo "Administrator account has been created!<br />";
        echo "The username is 'Admin'. <br />";
        echo "The password is 'password'. <br />";
    } else {
        echo "The Administrator account already exist!";
    }
}
