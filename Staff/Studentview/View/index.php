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
        if(!$perms->HasPermByPermNameFromArray(array("Tutor")) || !isset($_GET["ID"])){
            $header = 'Location: /Staff/StudentView';
            header($header, true, 301);
        }
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $header = 'Location: /staff/Studentview/View/Addrole/?ID='.$_POST["ID"]."&Role=".$_POST["Role"];
            header($header, true, 301);
        }
    ?>
    <div id="app">
        <?php 

            include "C:/xampp/htdocs/GibJohn/includes/cover.php";
            include "C:/xampp/htdocs/GibJohn/includes/header.php";
            include "C:/xampp/htdocs/GibJohn/includes/nav.php";
            $info = new DisplayUserInfo();
        ?>
        <div id="content">
            <div id="user-name">
                <h2><?php $info->DisplayUsername($_GET["ID"]); ?></h2>
            </div>
            <div id="user-info">
                <h3>Student Info</h3>
                <?php $info->DisplayUserInfo($_GET["ID"]); ?>
            </div>
            <div id="view-roles">
                <h3>Reports</h3>
                <table>
                    <tr><td>Title</td><td>Type</td><td>Madeby</td><th><button class="Update" onclick="location.reload()">Update</button></th></tr>
                    <?php $reports = new DisplayReports(); $reports->DisplayReportsSecondary($_GET["ID"]) ?>
                </table>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("cover").style.display = "none";
    </script>
</body>
</html>