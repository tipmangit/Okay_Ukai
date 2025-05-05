<?php
include_once "../php/config2.php";
$order_id = $_POST['record']; // Use the correct variable name
$sql = "SELECT order_status FROM orders WHERE id='$order_id'"; 
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($row["order_status"] == 0) {
    $update = mysqli_query($conn, "UPDATE orders SET order_status=1 WHERE id='$order_id'");
} else if ($row["order_status"] == 1) {
    $update = mysqli_query($conn, "UPDATE orders SET order_status=0 WHERE id='$order_id'");
}

if ($update) {
     echo "success"; // Return success message
 } else {
     echo "error"; // Return error message
 }
 
?>