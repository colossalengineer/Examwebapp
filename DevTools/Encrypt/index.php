<!DOCTYPE html>
<?php 
    // General Functions
    include "C:/xampp/htdocs/GibJohn/includes/functions.php";
    include "C:/xampp/htdocs/GibJohn/includes/functions/DisplayUser.php";
    // Check permissions
    $perm = new perms();
    if(!$perm->HasPermByPermName("Dev")){
        $header = 'Location: /Dashboard/';
        header($header, true, 301);
    }
    $encrypt = new data();
?>
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
    <div id="app">
        <?php
            // Static elements
            include "C:/xampp/htdocs/GibJohn/includes/cover.php";
            include "C:/xampp/htdocs/GibJohn/includes/header.php";
            include "C:/xampp/htdocs/GibJohn/includes/nav.php";
        ?>
        <div id="content">
            <!-- Encryption -->
            <?php 
                    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["encrypt"])){
                        echo $encrypt->encrypt($_POST["data"]);
                    }
                    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["decrypt"])){
                        echo $encrypt->decrypt($_POST["data"]);
                    }
                    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["encryptpass"])){
                        $temp = password_hash($_POST["data"],PASSWORD_DEFAULT);
                        echo $encrypt->encrypt(password_hash($_POST["data"],PASSWORD_DEFAULT));
                    }
                ?>
            <form method="post" name="encrypt">
                <input type="text" name="data">
                <input type="submit" value="Encrypt" name="encrypt">
            </form>
            <form method="post" name="decrypt">
                <input type="text" name="data">
                <input type="submit" value="Decrypt" name="decrypt">
            </form>
            <form method="post" name="encryptpass">
                <input type="text" name="data">
                <input type="submit" value="EncryptPass" name="encryptpass">
            </form>
        </div>
    </div>
    <script>
        document.getElementById("cover").style.display = "none";
    </script>
</body>

</html>