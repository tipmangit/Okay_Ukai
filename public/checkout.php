<?php
require 'php/config2.php';

$grand_total = 0;
$allItems = '';
$items = array();

$sql = "SELECT prodname AS ItemQty, totalprice FROM cartdb";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

while($row = $result->fetch_assoc()){
    $grand_total += $row['totalprice'];
    $items[] = $row['ItemQty'];
}

$allItems = implode(", ", $items);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Okay_Ukai Thrift Shop - Checkout</title>
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center" >
        <div class="col-lg-6 px-4 pb-4" id="order">
            <div class="text-center mb-4">
                <h2>Checkout</h2>
            </div>

            <div class="card shadow-sm border-0 rounded-lg text-center mb-3">
                <h6><b>Product(s): </b><?= $allItems; ?></h6>
                <h6><b>Delivery Charge: </b>Free</h6>
                <h5><b>Total Amount Payable: </b>₱<?= number_format($grand_total, 2) ?>/-</h5>
            </div>

            <!-- Checkout Form -->
            <form action="" method="post" id="placeOrder">
                <input type="hidden" name="products" value="<?= $allItems; ?>">
                <input type="hidden" name="grand_total" value="<?= $grand_total; ?>">

                <div class="form-group mb-2">
                    <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
                </div>
                <div class="form-group mb-2">
                    <input type="text" name="username" class="form-control" placeholder="Enter Username" required>
                </div>
                <div class="form-group mb-2">
                    <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                </div>
                <div class="form-group mb-2">
                    <input type="tel" name="phone" class="form-control" placeholder="Enter Phone" required>
                </div>
                <div class="form-group mb-2">
                    <textarea name="address" class="form-control" rows="3" placeholder="Enter Delivery Address..."></textarea>
                </div>
                <div class="form-group mb-2">
                    <select name="pmode" class="form-control" required>
                        <option value="" disabled selected>-Select Payment Method-</option>
                        <option value="cod">Cash on Delivery</option>
                        <option value="netbanking">Net Banking</option>
                        <option value="cards">Debit/Credit Card</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <select name="shipmode" class="form-control" required>
                        <option value="" disabled selected>-Select Shipping Method-</option>
                        <option value="Ninja Van">Ninja Van</option>
                        <option value="J&T">J&T</option>
                        <option value="Flash Express">Flash Express</option>
                    </select>
                </div>
                <div class="form-group d-grid">
                    <input type="submit" name="submit" value="Place Order" class="btn btn-danger">
                </div>
            </form>

            <!-- Confirmation Message Will Appear Here -->
            <div id="orderConfirmation" class="mt-4"></div>
        </div>
    </div>
</div>

<script src="jquery-3.7.1.js"></script>
<script>
$(document).ready(function() {
    $("#placeOrder").submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: 'action.php',
            method: 'POST',
            data: $(this).serialize() + "&action=order",
            success: function(response) {
                $("#placeOrder").hide(); // hide form
                $("#orderConfirmation").html(response); // show result below
                $('html, body').animate({
                    scrollTop: $("#orderConfirmation").offset().top
                }, 800);
            }
        });
    });
});
</script>

</body>
</html>
