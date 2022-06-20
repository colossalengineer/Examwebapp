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
        if(!$perms->HasPermByPermNameFromArray(array("H.Tutor","S.Tutor","TutorP","M.Management"))){
            $header = 'Location: /Dashboard/';
            header($header, true, 301);
        }
    ?>
    <div id="app">
        <?php 
            include "C:/xampp/htdocs/GibJohn/includes/cover.php";
            include "C:/xampp/htdocs/GibJohn/includes/header.php";
            include "C:/xampp/htdocs/GibJohn/includes/nav.php";
        ?>
        <div id="content">
            <div id="viewusers">
                <h1>Assign Tutors</h1>
                <?php 
                    $assign = new assign();
                    $list = new ListUsers();
                    if($_SERVER["REQUEST_METHOD"] === "POST"){
                        $assign->Assign("Student",$_POST["Tutor"],$_POST["Student"]);
                    }
                ?>
                <form method="POST">
                    <select name="Tutor" id="" autofocus>
                        <?php $list->ListUsers("Tutors") ?>
                    </select>
                    <select name="Student" id="">
                        <?php $list->ListUsers("Student") ?>
                    </select>
                    <input type="submit" value="Assign" value="Assign">
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("cover").style.display = "none";
    </script>
</body>
</html>