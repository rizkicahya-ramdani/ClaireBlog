<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "my_database";

$connection = mysqli_connect($hostname, $username, $password, $database);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully";
}