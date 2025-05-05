<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style\style.css">
    <title>Forgot Password</title>
</head>
<body>
        <div class="container">
            <div class="box form-box">

            <?php
                include("php/config.php");
                if (isset($_POST['submit'])) {
                    $username = mysqli_real_escape_string($con, $_POST['username']);
                    $pet_name = mysqli_real_escape_string($con, $_POST['pet_name']);

                    // Query to check username and pet name
                    $query = "SELECT * FROM users WHERE username='$username' AND security_answer='$pet_name'";
                    $result = mysqli_query($con, $query);
                    $row = mysqli_fetch_assoc($result);

                    if ($row) {
                        // Security answer is correct, redirect to reset password page
                        $_SESSION['reset_user'] = $row['username'];
                        header("Location: reset_password.php");
                        exit();
                    } else {
                        $error = "Invalid username or pet's name.";
                    }
                }
            ?>

                <header>Change Password</header>
                <form action="" method="post">
                    <div class="field input">
                        <label for="username">Username</label>
                        <input type="text" id="username" autocomplete="off" name="username" required>
                    </div>

                    <div class="field input">
                        <label for="pet_name">What is your pet's name?</label>
                        <input type="text" id="pet_name" autocomplete="off" name="pet_name" required>
                    </div>

                    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
                    
                    <div class="field"> 
                    <button type="submit" class="btn" name="submit">Submit</button>
                    </div>
                    
                    <div class="links">
                        Already a member? <a href="login.php">Sign In</a>
                    </div>
                </form>
            </div>
        </div>
</body>
</html>
