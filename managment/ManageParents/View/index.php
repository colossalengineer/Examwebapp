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
        $session->CheckSession();

        include "C:/xampp/htdocs/GibJohn/includes/functions/DisplayUser.php";
        if(!$perms->HasPermByPermName("TutorP") || !isset($_GET["ID"])){
            $header = 'Location: /Dashboard/';
            header($header, true, 301);
        }
        $info = new DisplayUserInfo();
    ?>
    <div id="app">
        <?php 
            include "C:/xampp/htdocs/GibJohn/includes/cover.php";
            include "C:/xampp/htdocs/GibJohn/includes/header.php";
            include "C:/xampp/htdocs/GibJohn/includes/nav.php";
            if($_SERVER["REQUEST_METHOD"] === "POST"){
                $header = 'Location: /managment/ManageTutors/View/Addrole/?ID='.$_POST["ID"]."&Role=".$_POST["Role"];
                header($header, true, 301);
            }
        ?>
        <div id="content">
            <div id="user-name">
                <?php $info->DisplayUsername($_GET["ID"]); ?>
            </div>
            <aside id="user-info">
                <h3>Parents Info</h3>
                <?php $info->DisplayUserInfo($_GET["ID"]); ?>
            </aside>
        </div>
    </div>
    <script>
        document.getElementById("cover").style.display = "none";
    </script>
</body>
</html>