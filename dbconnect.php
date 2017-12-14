<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$DbName = $_SESSION["roll_no"];

// Create connection
$conn = new mysqli($servername, $username, $password, $DbName);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
