<?php 
session_start();
include("php/config.php");

if (!isset($_SESSION['valid'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['id'];

// Fetch user info
$query = mysqli_query($con, "SELECT * FROM users WHERE user_id = $id");
if ($result = mysqli_fetch_assoc($query)) {
    $res_name = $result['name'];
    $res_uname = $result['username'];
    $res_contact = $result['contact'];
}

$errors = [];

if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $contact = trim($_POST['contact']);

    // Name validation
    if (!preg_match("/^[a-zA-Z\s'-]+$/", $name)) {
        $errors[] = "Invalid name. Use letters, spaces, apostrophes, or hyphens only.";
    }

    // Username validation
    if (!preg_match("/^[a-zA-Z0-9]+$/", $username)) {
        $errors[] = "Invalid username. Use letters and numbers only, no spaces or special characters.";
    }

    // Unique username check excluding current user
    $check = $con->prepare("SELECT username FROM users WHERE username = ? AND user_id != ?");
    $check->bind_param("si", $username, $id);
    $check->execute();
    $result = $check->get_result();
    if ($result->num_rows > 0) {
        $errors[] = "Username is already taken. Please try another.";
    }

    // Contact number validation (Philippines)
    if (!preg_match('/^(\+63|0)9\d{9}$/', $contact)) {
        $errors[] = "Invalid contact number. Must be a valid Philippine number.";
    }

    // If no errors, update the profile
    if (empty($errors)) {
        $stmt = $con->prepare("UPDATE users SET name = ?, username = ?, contact = ? WHERE user_id = ?");
        $stmt->bind_param("sssi", $name, $username, $contact, $id);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Profile Updated!</div>";
            // Refresh session username if changed
            $_SESSION['valid'] = $username;
        } else {
            echo "<div class='alert alert-danger'>Error updating profile.</div>";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <!-- fontawesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- bootstrap css -->
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <!-- custom css -->
    <link rel="stylesheet" href="main.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white py-4 fixed-top">
    <div class="container">
        <a class="navbar-brand d-flex justify-content-between align-items-center order-lg-0" href="index.php">
            <img src="logo/okay_ukai.png" alt="site icon" style="border-radius: 50%;">
            <span class="text-uppercase fw-lighter ms-2">Okay Ukai</span>
        </a>

        <div class="order-lg-2 nav-btns">
            <button type="button" class="btn position-relative" onclick="location.href='cart.php'">
                <i class="fa fa-shopping-cart"></i>
                <span id="cart-item" class="position-absolute top-0 start-100 translate-middle badge bg-primary"></span>
            </button>
            <button type="button" class="btn position-relative">
                <i class="fa fa-heart"></i>
            </button>
            <button type="button" class="btn position-relative">
                <i class="fa fa-search"></i>
            </button>
            <form action="php/logout.php" method="post" style="display: inline;">
                <button type="submit" class="btn position-relative">Log Out</button>
            </form>
        </div>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-lg-1" id="navMenu">
            <ul class="navbar-nav mx-auto text-center">
                <li class="nav-item px-2 py-2"><a class="nav-link text-uppercase text-dark" href="index.php">Home</a></li>
                <li class="nav-item px-2 py-2"><a class="nav-link text-uppercase text-dark" href="index.php #collection">Collection</a></li>
                <li class="nav-item px-2 py-2"><a class="nav-link text-uppercase text-dark" href="product.php">Shop</a></li>
                <li class="nav-item px-2 py-2"><a class="nav-link text-uppercase text-dark" href="index.php #special">Specials</a></li>
                <li class="nav-item px-2 py-2"><a class="nav-link text-uppercase text-dark" href="index.php #about">About</a></li>
                <li class="nav-item px-2 py-2 border-0"><a class="nav-link text-uppercase text-dark" href="edit.php">Edit Profile</a></li>
                <li class="nav-item px-2 py-2 border-0">
                    <p class="nav-link text-uppercase text-dark mb-0">Hello <b><?php echo htmlspecialchars($res_uname); ?></b>, Welcome</p>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->

<!-- Edit Profile Section -->
<section class="py-5" style="margin-top: 120px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="mb-0">Edit Profile</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" id="name" value="<?php echo htmlspecialchars($res_name); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" id="username" value="<?php echo htmlspecialchars($res_uname); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="contact" class="form-label">Contact</label>
                                <input type="text" class="form-control" name="contact" id="contact" value="<?php echo htmlspecialchars($res_contact); ?>" required>
                            </div>
                            <div class="d-grid">
                                <input type="submit" class="btn btn-success" name="submit" value="Update">
                            </div>
                        </form>
                    </div>

                    <?php
                    if (!empty($errors)) {
                        echo "<div class='alert alert-danger'><ul class='mb-0'>";
                        foreach ($errors as $error) {
                            echo "<li>$error</li>";
                        }
                        echo "</ul></div>";
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Edit Profile -->

<!-- Scripts -->
<script src="jquery-3.7.1.js"></script>
<script src="bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<script src="script.js"></script>

<script>
    load_cart_item_number();

    function load_cart_item_number() {
        $.ajax({
            url: 'action.php',
            method: 'get',
            data: { cartItem: "cart_item" },
            success: function (response) {
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
