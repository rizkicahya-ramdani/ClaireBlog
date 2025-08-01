<?php

$hostname = "db";
$username = "bloguser";
$password = "blogpass";
$database = "db_blog";

$connection = mysqli_connect($hostname, $username, $password, $database);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    // echo "Connected successfully";
}