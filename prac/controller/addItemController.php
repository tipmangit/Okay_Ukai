<?php
include_once "../php/config.php";

if (isset($_POST['upload'])) {
    $ProductName = $_POST['p_name'];
    $price = $_POST['p_price'];
    $link = $_POST['p_link']; 

    $name = $_FILES['file']['name'];
    $temp = $_FILES['file']['tmp_name'];

    $location = "./uploads/";
    $image = $location . $name;

    $target_dir = "../uploads/";
    $finalImage = $target_dir . $name;

    // move image to uploads folder
    move_uploaded_file($temp, $finalImage);

    // insert new product into DB
    $insert = mysqli_query($con, "INSERT INTO product (product_name, product_image, price, link) 
                                  VALUES ('$ProductName', '$image', '$price', '$link')");

    if (!$insert) {
        echo mysqli_error($con);
    } else {
        echo "Records added successfully.";
    }
}
?>
