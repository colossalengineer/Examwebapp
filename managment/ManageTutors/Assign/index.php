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
        if(!$perms->HasPermByPermNameFromArray(array("H.Tutor","S.Tutor","M.Management"))){
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
                <table id="audit">
                    <tr id="head"><th>Staff's First Name</th><th>Staff's  LastName</th><th>Staff's  Title</th><th>Student's FirstName</th><th>Student's LastName</th><th><a href="/managment/ManageTutors/Assign/Assign/"><button class="Update">Asign Tutor<img alt="Asign Tutor" src="/static/images/user-group-solid.svg"></button></a></th></tr>
                    <?php $users = new DisplayUsersAssign(); $users->DisplayUsers("Student"); ?>
                </table>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("cover").style.display = "none";
    </script>
</body>
</html>