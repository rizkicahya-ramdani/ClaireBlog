<?php

$isDocker = strpos($_SERVER['REMOTE_ADDR'], '172.') === 0 || getenv('DOCKER') === 'true';

$hostname = $isDocker ? 'db' : 'localhost'; # db for docker, localhost for laragon/local
$username = $isDocker ? "bloguser" : 'root';
$password = $isDocker ? "blogpass" : '';
$database = "db_blog";

$connection = mysqli_connect($hostname, $username, $password, $database);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    // echo "Connected successfully";
}