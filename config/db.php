<?php
$host = 'localhost';
$dbname = 'ddms';
$username = 'root'; // Default XAMPP username
$password = ''; // Default XAMPP password (empty)

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
