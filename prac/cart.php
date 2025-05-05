<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Okay_Ukai Thrift Shop</title>
        <!-- fontawesome cdn -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- bootstrap css -->
        <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
        <!-- custom css -->
        <!-- <link rel="stylesheet" href="main.css"> -->
        <link rel="stylesheet" href="prodstyle.css">
        <link rel="stylesheet" href="shop.css">
        <link rel="stylesheet" href="main.css">
        <!-- Isotope CSS -->
        <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
        

    </head>
    


<body>

<nav class = "navbar navbar-expand-lg navbar-light bg-white py-4">
        <div class = "container">
            <a class = "navbar-brand d-flex justify-content-between align-items-center order-lg-0" href = "index.php">
                <img src = "logo/okay_ukai.png" alt = "site icon" style="border-radius: 50%;">
                <span class = "text-uppercase fw-lighter ms-2">Okay Ukai    </span>
            </a>

            <div class = "order-lg-2 nav-btns">
                <button type = "button" class = "btn position-relative">
                <button type = "button" class = "btn position-relative" onclick = "location.href='cart.php'"><i class = "fa fa-shopping-cart"></i>
                    <span id="cart-item" class = "position-absolute top-0 start-100 translate-middle badge bg-primary"></span>
                </button>
                <button type = "button" class = "btn position-relative">
                    <i class = "fa fa-heart"></i>
                    <span class = "position-absolute top-0 start-100 translate-middle badge bg-primary"></span>
                </button>
                <button type = "button" class = "btn position-relative">
                    <i class = "fa fa-search"></i>
                </button>
            </div>

            <button class = "navbar-toggler border-0" type = "button" data-bs-toggle = "collapse" data-bs-target = "#navMenu">
                <span class = "navbar-toggler-icon"></span>
            </button>

            <div class = "collapse navbar-collapse order-lg-1" id = "navMenu">
                <ul class = "navbar-nav mx-auto text-center">
                    <li class = "nav-item px-2 py-2">
                        <a class = "nav-link text-uppercase text-dark" href = "index.php">home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
  
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-lg-10">
        <div class = "title text-center">
            <h2 class = "position-relative d-inline-block">Shopping Cart</h2>
        </div>
        <div style="display:<?php if(isset($_SESSION['showAlert'])){echo $_SESSION['showAlert'];}else{ echo 'none'; } unset($_SESSION['showAlert']); ?>" class="alert alert-success alert-dismissible mt-3">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong><?php if(isset($_SESSION['message'])){echo $_SESSION['message'];} unset($_SESSION['showAlert']); ?></strong> 
        </div>
            <div class="table-responsive mt-2">
            <table class="table table-bordered table-striped text-center">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>
                        <a href="action.php?clear=all" class="badge bg-danger p-1" 
                        onclick="return confirm('Are you sure to clear your cart?');" 
                        style="text-decoration: none; "><i class="fas fa-trash"></i>&nbsp;&nbsp;Clear Cart</a>
                    </th>
                </tr>
                </thead>
                <tbody>
                    <?php   
                        require 'php/config2.php';
                        $stmt = $conn->prepare("SELECT * FROM cartdb");
                        $stmt->execute();
                        $result= $stmt->get_result();
                        $grand_total = 0;
                        while($row= $result->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?= $row['id']?></td>
                        <input type="hidden" class="pid" value="<?= $row['id'] ?>">
                        <td><img src="<?= $row['prodimage']?>" width="50"></td>
                        <td><?= $row['prodname'] ?></td>
                        <td>₱<?=number_format($row['prodprice'],2) ?></td>
                        <input type="hidden" class="pprice" value="<?= $row['prodprice']?>">
                        <td>
                            <a href="action.php?remove=<?= $row['id'] ?>" class="text-danger lead"
                            onclick="return confirm('Are you sure you want to remove this item?');">
                            <i class="fas fa-trash-alt lead"></i></a>
                        </td>
                    </tr>
                    <?php $grand_total +=$row['prodprice']; ?>
                    <?php endwhile; ?>
                    <tr>
                        <td colspan="2">
                            <a href="product.php" class="btn btn-success"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Continue Shopping</a>
                        </td>
                        <td><b>Grand Total</b></td>
                        <td><b>₱<?=number_format($grand_total,2) ?></b></td>
                        <td>
                            <a href="checkout.php" class="btn btn-info <?= ($grand_total>0)?"":"disabled";?>">
                                <i class="far fa-credit-card"></i>&nbsp;&nbsp;Checkout</a>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
        </div>
    </div>



    <!-- JQuery JS -->
     <script src="jquery-3.7.1.js"></script>

    <!-- isotope -->
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.js"></script>

    <!--Boostrap JS -->
    <script src="bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
    <script type="text/javascript">

load_cart_item_number();

function load_cart_item_number(){
    $.ajax({
        url: 'action.php',
        method: 'get',
        data: {cartItem: "cart_item"},
        success: function(response){
            if (response == 0 || response == null || response.trim() === "") {
                $("#cart-item").hide();
            } else {
                $("#cart-item").show().html(response);
            }
        }
    });
}
    </script>
</body>
</html>
