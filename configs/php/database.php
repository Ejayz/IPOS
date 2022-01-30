<?php
error_reporting();
$username = 'root';
$password = '';
$host = "localhost";
$database = "pointofsales";
$port = 3306;
try {

    $connect = mysqli_connect($host, $username, $password, $database, $port);
} catch (Exception $e) {
    echo "Cannot connect to database : 500 Internal Server error";
}
