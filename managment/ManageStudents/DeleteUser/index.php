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
        if(!$perms->HasPermByPermNameFromArray(array("root","S.Management","H.Management"))){
            $header = 'Location: /Dashboard/';
            header($header, true, 301);
        }
    ?>
    <div id="app">
        <?php 
            include "C:/xampp/htdocs/GibJohn/includes/cover.php";
            include "C:/xampp/htdocs/GibJohn/includes/header.php";
            include "C:/xampp/htdocs/GibJohn/includes/nav.php";
            $del = new DeleteUser();
            $del->DeleteUser("Student");
        ?>
        <div id="content">
            <?php if(isset($_GET["ID"])){?>
            <form method="POST">
                <h3>Are you sure that you want to delete: <?php echo $perms->GetNameOfUserByID($_GET["ID"]); ?></h3>
                <input type="text" name="ID" value="<?php echo $_GET["ID"]; ?>" hidden>
                <a href="/managment/ManageStudents/"><input type="button" value="Cancel"></a>
                <input type="submit" value="Delete">
            </form>
            <?php } ?>
        </div>
    </div>
    <script>
        document.getElementById("cover").style.display = "none";
    </script>
</body>
</html>