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
    ?>
    <div id="app">
        <?php 
            include "C:/xampp/htdocs/GibJohn/includes/cover.php";
            include "C:/xampp/htdocs/GibJohn/includes/header.php";
        ?>
        <div id="full-content">
                <a href="/Students/SubjectContent/?ID=<?php echo $_GET["SID"] ?>"><button class="Update">Back</button></a>
            <div id="View">
                <div id="Questions">
                    <?php $form = new DisplayForms(); $form->DisplayForm($_GET["FID"]) ?>
                </div>
            </div>
        </div>
    </div>
    <script>
    document.getElementById("cover").style.display = "none";
    </script>
</body>

</html>