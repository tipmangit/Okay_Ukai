<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Login</title>
</head>
<body>
        <div class="container">
            <div class="box form-box">

                <?php 
                    include("php/config.php");
                    if (isset($_POST['submit'])) {
                        $username = mysqli_real_escape_string($con, $_POST['username']);
                        $password = $_POST['password']; // Don't escape passwords unnecessarily
                    
                        // 🔐 User login
                        $stmt = $con->prepare("SELECT * FROM users WHERE username = ?");
                        $stmt->bind_param("s", $username);
                        $stmt->execute();
                        $result = $stmt->get_result();
                    
                        if ($row = $result->fetch_assoc()) {
                            if (password_verify($password, $row['password'])) {
                                $_SESSION['valid'] = $row['username'];
                                $_SESSION['name'] = $row['name'];
                                $_SESSION['contact'] = $row['contact'];
                                $_SESSION['id'] = $row['user_id'];
                                header("Location:/prac/index.php");
                                exit();
                            }
                        }
                    
                        // 🔐 Admin login
                        $stmt = $con->prepare("SELECT * FROM admins WHERE username = ?");
                        $stmt->bind_param("s", $username);
                        $stmt->execute();
                        $admin_result = $stmt->get_result();
                    
                        if ($admin = $admin_result->fetch_assoc()) {
                            if (password_verify($password, $admin['password_hash'])) {
                                $_SESSION['admin'] = $admin['username'];
                                $_SESSION['admin_id'] = $admin['id'];
                                header("Location: /prac/adminindex.php");
                                exit();
                            }
                        }
                    
                        echo "<div class='message'><p>Wrong Username or Password</p></div><br>";
                        echo "<a href='login.php'><button class='btn'>Go Back</button>";
                    } else {
                ?>

                <header>Login</header>
                <form action="" method="post">
                    <div class="field input">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" autocomplete="off" required>
                    </div>

                    <div class="password-field">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" autocomplete="off" required>
                        <button type="button" class="toggle-btn" onclick="togglePassword('password', this)">🙈</button>
                    </div>

                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Login">
                    </div>
                    <div class="links">
                        Don't have an account? <a href="register.php">Sign Up Now</a> <br>
                        <a href="forgot_password.php">Forgot Password?</a>
                    </div>
                </form>
            </div>
            <?php } ?>
        </div>
    <script> //peek password button script🙈🙉
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            if (input.type === "password") {
                input.type = "text";
                button.textContent = "🙉";
            } else {
                input.type = "password";
                button.textContent = "🙈";
            }
        }
    </script>
</body>
</html>
