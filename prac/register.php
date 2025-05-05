<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Register</title>
</head>
    <body>
            <div class="container">
                <div class="box form-box">

            <?php 
                include("php/config.php");
                $errors = [];

                if (isset($_POST['submit'])) {
                    $name = trim($_POST['name']);
                    $username = trim($_POST['username']);
                    $contact = trim($_POST['contact']);
                    $password = $_POST['password'];
                    $confirm_password = $_POST['confirm_password'];
                    $pet_name = trim($_POST['pet_name']);

                    // Name validation
                    if (!preg_match("/^[a-zA-Z\s'-]+$/", $name)) {
                        $errors[] = "• Invalid name. Use letters, spaces, apostrophes, or hyphens only.";
                    }

                    // Username validation
                    if (!preg_match("/^[a-zA-Z0-9]+$/", $username)) {
                        $errors[] = "• Invalid username. Use letters and numbers only, no spaces or special characters.";
                    }

                    // Unique username check
                    $check = $con->prepare("SELECT username FROM users WHERE username = ?");
                    $check->bind_param("s", $username);
                    $check->execute();
                    $result = $check->get_result();
                    if ($result->num_rows > 0) {
                        $errors[] = "• Username is already taken. Please try another.";
                    }

                    // Contact number validation (Philippines)
                    if (!preg_match('/^(\+63|0)9\d{9}$/', $contact)) {
                        $errors[] = "• Invalid contact number. Must be a valid Philippine number.";
                    }

                    // Password validations
                    if ($password !== $confirm_password) {
                        $errors[] = "• Passwords do not match.";
                    }

                    if (strlen($password) < 8) {
                        $errors[] = "• Password must be at least 8 characters long.";
                    }

                    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])/', $password)) {
                        $errors[] = "• Password must include an uppercase letter, a lowercase letter, a number, and a special character.";
                    }

                    // If no errors, register user
                    if (empty($errors)) {
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                        $stmt = $con->prepare("INSERT INTO users (name, username, contact, password, security_answer) VALUES (?, ?, ?, ?, ?)");
                        $stmt->bind_param("sssss", $name, $username, $contact, $hashed_password, $pet_name);

                        if ($stmt->execute()) {
                            echo "<div class='message'><p>Registration successful!</p></div><br>";
                            echo "<a href='login.php'><button class='btn'>Login Now</button></a>";
                            exit();
                        } else {
                            $errors[] = "Registration failed. Please try again.";
                        }
                    }
                }
            ?>

                <header>Sign Up</header>
                    <form action="" method="post">
                        <div class="field input">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" autocomplete="on" required>
                        </div>

                        <div class="field input">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" autocomplete="on" required>
                        </div>

                        <div class="field input">
                            <label for="contact">Contact</label>
                            <input type="text" name="contact" id="contact" autocomplete="on" required>
                        </div>

                        <div class="password-field">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" autocomplete="off" required>
                            <button type="button" class="toggle-btn" onclick="togglePassword('password', this)">🙈</button>
                        </div>

                        <div class="password-field">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" name="confirm_password" id="confirm_password" autocomplete="off" required>
                            <button type="button" class="toggle-btn" onclick="togglePassword('confirm_password', this)">🙈</button>
                        </div>

                        <div class="field input">
                            <label for="pet_name">What is your pet's name? (Security Question)</label>
                            <input type="text" name="pet_name" id="pet_name" autocomplete="on" required>
                        </div>

                        <?php
                            if (!empty($errors)) {
                                foreach ($errors as $err) {
                                    echo "<p style='color:red;'>$err</p>";
                                }
                            }
                        ?>

                        <div class="field">
                            <input type="submit" class="btn" name="submit" value="Register">
                        </div>
                        <div class="links">
                            Already a member? <a href="login.php">Sign In</a>
                        </div>
                    </form>
                </div>
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
