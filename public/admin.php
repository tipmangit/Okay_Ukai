<?php
include("php/config.php");

$username = "admin";  // Replace with actual admin username
$password = "admin0412"; // Replace with actual password
$hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password

// Prepare SQL query to insert admin data
$sql = "INSERT INTO admins (username, password_hash) VALUES (?, ?)";
$stmt = $con->prepare($sql);
$stmt->bind_param("ss", $username, $hashed_password);

// Execute query and check for success
if ($stmt->execute()) {
    echo "Admin account created successfully!";
} else {
    echo "Error: " . $stmt->error;
}
?>
