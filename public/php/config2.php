<?php

$conn = new mysqli("localhost", "root", "", "okay_ukai");
if($conn->connect_error){
    die("Connection Failed!". $conn->connect_error);
}

?>