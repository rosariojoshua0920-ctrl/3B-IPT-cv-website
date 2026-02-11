<?php

//database

$host = "localhost";
$username = "root";
$password = "";
$dbname = "cv_website";

$conn = new mysqli($host, $username, $password, $dbname, 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
    echo "Connected successfully";
}
?>




