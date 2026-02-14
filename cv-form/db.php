<?php

//database

$host = "localhost";
$username = "root";
$password ="";
$dbname = "cv_website";

$conn = new mysqli($host, $username, $password, $dbname, 3306);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
    echo "Connected successfully";
}

$conn->set_charset("utf8mb4");
?>








