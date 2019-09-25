<?php
$servername = "208.97.172.139";
$username = "db_althaia";
$password = "equaliv@123";
$dbname = "db_althaia";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

//$conn->close();

?>