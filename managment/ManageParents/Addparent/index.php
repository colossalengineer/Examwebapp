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
        $perm = new perms();
        if(!$perms->HasPermByPermNameFromArray(array("TutorP"))){
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
            <?php 
                $register = new register();
                $register->register();
            ?>
            <form method="POST">
                <?php if($register->emailval == true){?> <p class="error"><?php echo "Invalid Email Format" ?></p> <?php } ?>
                <?php if($register->empty == true){?> <p class="error"><?php echo "Please fill in all the boxes" ?></p> <?php } ?>
                <input type="text" name="Type" value="Parent" hidden>
                <input type="text" name="FirstName" placeholder="First Name" value="">
                <input type="text" name="LastName" placeholder="Last Name" value="">
                <input type="email" name="Email" placeholder="Email" value="">
                <input type="phone" name="Phone" placeholder="Phone" value="">
                <div>
                    <input type="reset" name="Cancel" placeholder="Cancel" value="Cancel">
                    <input type="submit" name="Ceate" placeholder="Create" value="Create">
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById("cover").style.display = "none";
    </script>
</body>
</html>