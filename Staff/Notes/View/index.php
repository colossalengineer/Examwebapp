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
        if(!$perms->HasPermByPermNameFromArray(array("Tutor"))){
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
                <h1>Manage Students Reports</h1>
                <table id="audit">
                    <tr id="head"><th>Title</th><th>Review Type</th><th><button class="Update" onclick="location.reload()">Update</button></th><th><a href="/Staff/Notes/NewReport/?ID=<?php echo $_GET["ID"] ?>"><button class="Update">New Report</button></a></th></tr>
                    <?php $reports = new DisplayReports(); $reports->DisplayReportsMain($_GET["ID"]) ?>
                </table>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("cover").style.display = "none";
    </script>
</body>
</html>