<?php
$servername = "localhost";  // Change to your database host if necessary
$username = "root";         // Change to your MySQL username
$password = "";             // Change to your MySQL password
$database = "shopping_cart_db"; // Change to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
