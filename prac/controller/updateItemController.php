<?php
include_once "../php/config.php";

$product_id = $_POST['product_id'];
$p_name = $_POST['p_name'];
$p_price = $_POST['p_price'];
$p_link = $_POST['p_link']; // new link field

if (isset($_FILES['newImage']) && $_FILES['newImage']['error'] == 0) {
    $original_name = basename($_FILES['newImage']['name']); // original image name
    $tmp = $_FILES['newImage']['tmp_name'];

    $ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'webp');

    if (in_array($ext, $valid_extensions)) {
        $location = "./uploads/";
        $dir = '../uploads/';
        $final_image = $location . $original_name;
        
        move_uploaded_file($tmp, $dir . $original_name);
    } else {
        echo "Invalid file type";
        exit;
    }
} else {
    $final_image = $_POST['existingImage']; // use the existing image
}

$updateItem = mysqli_query($con, "UPDATE product SET 
    product_name = '$p_name', 
    price = $p_price,
    link = '$p_link',
    product_image = '$final_image' 
    WHERE product_id = $product_id");

if ($updateItem) {
    echo "true";
} else {
    echo mysqli_error($con);
}
?>
