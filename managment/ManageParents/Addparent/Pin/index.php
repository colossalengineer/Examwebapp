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
        include "C:/xampp/htdocs/GibJohn/includes/functions.php";
        $session = new session();
        $session->CheckSession();
        include "C:/xampp/htdocs/GibJohn/includes/functions/DisplayUser.php";
    ?>
    <div id="app">
        <?php 
            include "C:/xampp/htdocs/GibJohn/includes/cover.php";
            include "C:/xampp/htdocs/GibJohn/includes/header.php";
        ?>
        <div id="full-content">
            <div id="pin">
                <?php 
                    if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["Pin"])){?>
                        <h1><?php echo $_GET["username"]."'s " ?>pin is:</h1>
                        <h2><?php echo $_GET["Pin"] ?></h2> <?php
                    }
                ?>
                <a href="/managment/ManageParents/"><button>OK</button></a>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("cover").style.display = "none";
    </script>
</body>
</html>