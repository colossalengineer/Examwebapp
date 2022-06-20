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
        if(!$perms->HasPermByPermNameFromArray(array("root","S.Management","H.Management","H.Tutor")) || !isset($_GET["ID"])){
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
                if($_POST["Role"]){
                $header = 'Location: /managment/ManageStudents/View/Addrole/?ID='.$_POST["ID"]."&Role=".$_POST["Role"];
                header($header, true, 301);
                }else{
                $header = 'Location: /managment/ManageStudents/View/AddSubject/?ID='.$_POST["ID"]."&Role=".$_POST["Subject"];
                header($header, true, 301);
                }
            }
        ?>
        <div id="content">
            <div id="user-name">
                <?php $info->DisplayUsername($_GET["ID"]); ?>
            </div>
            <div id="user-info">
                <h3>Student Info</h3>
                <?php $info->DisplayUserInfo($_GET["ID"]); ?>
            </div>
            <div id="view-roles">
            <?php if($perms->HasPermByPermNameFromArray(array("H.Tutor"))){ ?>
            <h3>Edit Roles</h3>
            <div class="user-roles">
                <div class="display-roles">
                    <?php $info->DisplayUserStudentRoles($_GET["ID"]); ?>
                </div>
                <div class="button-roles">
                    <form id="roles" method="POST" name="Addroleform">
                        <input type="text" name="ID" hidden value="<?php echo $_GET["ID"]; ?>">
                        <select name="Role">
                            <?php $roles = $info->ListAllStudentRoles($_GET["ID"]); ?>
                        </select>
                        <input type="submit" value="Add Role" name="Addrole">
                    </form>
                    <?php if($roles){echo '<script>document.getElementById("roles").style.display = "none"</script>';}?>
                </div>
            </div>
            <?php }if($perms->HasPermByPermNameFromArray(array("TutorP"))){ ?>
            <h3>Edit subjects</h3>
            <div class="user-roles">
                    <div class="display-roles">
                    <?php $info->DisplayUserStudentSubjects($_GET["ID"]) ?>
                    </div>
                    <div id="button-roles">
                        <form id="subjects" method="POST" name="Addroleform">
                            <input type="text" name="ID" hidden value="<?php echo $_GET["ID"]; ?>">
                            <select name="Subject">
                                <?php $roles = $info->ListAllStudentSubjects($_GET["ID"]); ?>
                            </select>
                            <input type="submit" value="Add Subject" name="Addrole">
                        </form>
                        <?php if($roles){echo '<script>document.getElementById("subjects").style.display = "none"</script>';}?>
                    </div>
            </div>
            <?php } ?>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("cover").style.display = "none";
    </script>
</body>
</html>