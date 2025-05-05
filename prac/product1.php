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

<nav class = "navbar navbar-expand-lg navbar-light bg-white py-4 fixed-top">
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

  <section id="page-header">
        <h2>#StayThrifty</h2>
        <p>Save more on all products by referrals up to 30% off!</p>
    </section>
    <div class=" mt-2">
            <strong></strong>
        </div>
        <div class="container">
        <div id="message"></div>
         <div class="row mt-20 pb-20">

         <?php
            include 'php/config2.php';
            $stmt = $conn->prepare("SELECT * FROM prodlist");
            $stmt->execute();
            $result = $stmt->get_result();
            while($row = $result->fetch_assoc()):

         ?>
        
         <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
            <div class="card-deck">
                <div class="card p-2 border-secondary mb-2">
                    <img src="<?= $row['prodimage']?>" class="card-img-top" height="250">
                    <div class="card-body p-1">
                        <!-- <h5 class="card-title text-center "><?= $row['prodname'] ?></h5> -->
                    
                        <p class = "text-capitalize my-1"><?= $row['prodname'] ?></p>
                        <span class = "fw-bold">₱<?=number_format($row['prodprice'],2) ?></span>
                        <div class = "rating mt-3">
                            <span class = "text-primary"><i class = "fas fa-star"></i></span>
                            <span class = "text-primary"><i class = "fas fa-star"></i></span>
                            <span class = "text-primary"><i class = "fas fa-star"></i></span>
                            <span class = "text-primary"><i class = "fas fa-star"></i></span>
                            <span class = "text-primary"><i class = "fas fa-star"></i></span>
                            
                        </div>

                        <form action="" class="form-submit"> 
                            <input type="hidden" class="pid" value="<?= $row['id']?>"> 
                            <input type="hidden" class="pname" value="<?= $row['prodname']?>"> 
                            <input type="hidden" class="pprice" value="<?= $row['prodprice']?>"> 
                            <input type="hidden" class="pimage" value="<?= $row['prodimage']?>"> 
                            <input type="hidden" class="pcode" value="<?= $row['prodcode']?>"> 
             
                            <button class="btn btn-info btn-block addItemBtn"><i class="fas fa-cart-plus"></i>&nbsp add to cart</button>
                        </form>
                    </div>

             
                </div>
            </div>
         </div>

        <?php endwhile;?>
           
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
    </script>
</body>
</html>
