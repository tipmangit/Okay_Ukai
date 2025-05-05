<?php
session_start();
require 'php/config2.php';

    if(isset($_POST['pid'])){
        $pid = $_POST['pid'];
        $pname = $_POST['pname'];
        $pprice = $_POST['pprice'];
        $pimage = $_POST['pimage'];
        $pcode = $_POST['pcode'];
        $plink = $_POST['plink'];

        $stmt = $conn->prepare("SELECT prodcode FROM cartdb WHERE prodcode=?");
        $stmt->bind_param("s",$pcode);
        $stmt->execute();    
        $res = $stmt->get_result();
        $r = $res->fetch_assoc();
        // $code = $r['prodcode'];
        $code = $r['prodcode'] ?? '';
        
        if(!$code){
            $query = $conn->prepare("INSERT INTO cartdb (prodname,prodprice,prodimage,totalprice,prodcode,link) VALUES (?,?,?,?,?,?)");

            $query->bind_param("ssssss",$pname,$pprice,$pimage,$pprice,$pcode,$plink);
            $query->execute();

            echo '<div class="alert alert-success alert-dismissible mt-2">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <strong>Item added to your cart!</strong> 
                        </div>';
        }
        else{

            echo '<div class="alert alert-danger alert-dismissible mt-2">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Item already added to your cart!</strong>
            </div>';
        }
    }

    if(isset($_GET['cartItem']) && isset($_GET['cartItem']) == 'cart_item'){
        $stmt = $conn->prepare("SELECT * FROM cartdb");
        $stmt ->execute();
        $stmt ->store_result();
        $rows = $stmt->num_rows;

        echo $rows;
    }

    if(isset($_GET['remove'])){
        $id = $_GET['remove'];

        $stmt = $conn->prepare("DELETE FROM cartdb WHERE id=?");
        $stmt->bind_param("i",$id);
        $stmt->execute();

        $_SESSION['showAlert'] = 'block';
        $_SESSION['message'] = 'Item removed from the cart!';
        header('location:cart.php');
    }

    if(isset($_GET['clear'])){
        $stmt = $conn->prepare("DELETE FROM cartdb");
        $stmt->execute();
        $_SESSION['showAlert'] = 'block';
        $_SESSION['message'] = 'All items removed from the cart!';
        header('location:cart.php');
    }

    if (isset($_POST['action']) && $_POST['action'] === 'order') {
        $name = trim($_POST['name']);
        $uname = trim($_POST['username']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $products = $_POST['products'];
        $grand_total = $_POST['grand_total'];
        $address = trim($_POST['address']);
        $pmode = $_POST['pmode'];
        $shipmode = $_POST['shipmode'];

        $errors = [];

        // Validation
        if (!preg_match("/^[a-zA-Z\s'-]+$/", $name)) {
            $errors[] = "Invalid name.";
        }

        if (!preg_match("/^[a-zA-Z0-9]+$/", $uname)) {
            $errors[] = "Invalid username.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }

        if (!preg_match('/^(\+63|0)9\d{9}$/', $phone)) {
            $errors[] = "Invalid Philippine phone number.";
        }

        if (empty($address)) {
            $errors[] = "Address cannot be empty.";
        }

        if (empty($pmode)) {
            $errors[] = "Please select a payment mode.";
        }

        if (empty($shipmode)) {
            $errors[] = "Please select a shipping method.";
        }

        if (!empty($errors)) {
            echo '<div class="alert alert-danger"><ul>';
            foreach ($errors as $error) {
                echo "<li>$error</li>";
            }
            echo '</ul></div>';
            echo '
            <div class="form-group d-grid">
                <input type="submit" onclick="location.reload();" name="Try Again" value="Try Again" class="btn btn-danger">
            </div>';
            exit;
        }

        // Save order
        $stmt = $conn->prepare("INSERT INTO orders (name, username, email, phone, address, pmode, shipmode, products, amount_paid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $name, $uname, $email, $phone, $address, $pmode, $shipmode, $products, $grand_total);
        $stmt->execute();

        // Clear cart
        $conn->query("DELETE FROM cartdb");

        // Confirmation message
        echo '
        <div class="text-center">
            <h1 class="display-4 text-danger">Thank You!</h1>
            <h2 class="text-success">Your Order Was Placed Successfully!</h2>
            <h4 class="bg-danger text-light rounded p-2">Items Purchased: ' . htmlspecialchars($products) . '</h4>
            <h4>Your Name: ' . htmlspecialchars($name) . '</h4>
            <h4>Your Username: ' . htmlspecialchars($uname) . '</h4>
            <h4>Your Email: ' . htmlspecialchars($email) . '</h4>
            <h4>Your Phone: ' . htmlspecialchars($phone) . '</h4>
            <h4>Total Amount Paid: ₱' . number_format($grand_total, 2) . '</h4>
            <h4>Payment Method: ' . htmlspecialchars($pmode) . '</h4>
            <h4>Shipping Method: ' . htmlspecialchars($shipmode) . '</h4>
        </div>
        <form action="index.php" class="mt-3">
            <div class="form-group d-grid">
                <input type="submit" value="Back to Home" class="btn btn-primary">
            </div>
        </form>';
    }
?>

