<?php 
   session_start();

   include("php/config.php");
   if(!isset($_SESSION['valid'])){
    header("Location: login.php");
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Home</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php">Logo</a> </p>
        </div>
            

        <div class="right-links">
            
            <?php 
            
            $id = $_SESSION['id'];
            $query = mysqli_query($con,"SELECT*FROM users WHERE Id=$id");

            if($result = mysqli_fetch_assoc($query)){
                $res_name = $result['name'];
                $res_uname = $result['username'];
                $res_contact = $result['contact'];
                $res_id = $result['Id'];
            }
            
            // echo "<a href='edit.php?Id=$res_id'>Change Profile</a>";
            ?>
            <div class="hello">
                <p>Hello <b><?php echo $res_name ?></b>, Welcome</p>
            

            <a href="php/logout.php"> <button class="btn">Log Out</button> </a>
        </div>
        </div>
    </div>
    <main>

       
    </main>
</body>
</html>