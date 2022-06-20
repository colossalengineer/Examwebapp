<!DOCTYPE html>
<!-- Auther: TJ Navarro-Barer -->
<!-- Version: <?php include "C:/xampp/htdocs/GibJohn/includes/functions/version2.php"; ?> -->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>GibJohn</title>
    <meta name="author" content="TJ Navarro-Barer">
    <meta name="version" content="<?php include "C:/xampp/htdocs/GibJohn/includes/functions/version2.php"; ?>">
    <meta name="description" content="GibJohn Tutoring App">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="">
    <link rel="stylesheet" href="/static/CSS/Universal.css">
</head>

<body>
    <?php
        $page = "login";
        include "C:/xampp/htdocs/GibJohn/includes/functions.php";
        $login = new login();
        $login->login();
    ?>
    <div id="app">
        <?php 
            include "C:/xampp/htdocs/GibJohn/includes/cover.php";
            include "C:/xampp/htdocs/GibJohn/includes/header.php";
        ?>
        <div id="full-content">
            <section class="login">
                <form class="login-form" method="POST">
                    <h2>Login</h2>
                    <?php if($login->incorrect == true){?> <p class="error"><?php echo "Username or Password incorrect" ?></p> <?php } ?>
                    <?php if($login->error == true){?> <p class="error"><?php echo "An error has accured please contact Gibjohn support"; ?></p> <?php } ?>
                    <?php if($login->empty == true){?> <p class="error"><?php echo "please fill in the boxes below"; ?></p> <?php } ?>
                    <?php if($login->deactive == true){?> <p class="error"><?php echo "You account is disabled please contact Gibjohn support"; ?></p> <?php } ?>
                    <h3>Username</h3>
                    <input type="text" name="Username" placeholder="Username" value="<?php if(isset($_POST["Username"])){echo $_POST["Username"];} ?>">
                    <h3>Password</h3>
                    <input type="password" name="Password" placeholder="Password" value="<?php if(isset($_POST["Password"])){echo $_POST["Password"];} ?>">
                    <input type="submit">
                </form>
            </section>
        </div>
    </div>
    <script>
        document.getElementById("cover").style.display = "none";
    </script>
</body>
</html>