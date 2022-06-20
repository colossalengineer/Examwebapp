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
        if(!$perms->HasPermByPermNameFromArray(array("H.Tutor","S.Tutor","M.Management")) || !isset($_GET["ID"])){
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
                if($_POST["Addroleform"]){
                    $header = 'Location: /managment/ManageTutors/View/Addrole/?ID='.$_POST["ID"]."&Role=".$_POST["Role"];
                    header($header, true, 301);
                }else{
                    $header = 'Location: /managment/ManageTutors/View/AddSubject/?ID='.$_POST["ID"]."&Role=".$_POST["Role"];
                header($header, true, 301);
                }
            }
        ?>
        <div id="content">
            <div id="user-name">
                <?php $info->DisplayUsername($_GET["ID"]); ?>
            </div>
            <div id="user-info">
                <h3>Tutor Info</h3>
                <?php $info->DisplayUserInfo($_GET["ID"]); ?>
            </div>
            <div id="view-roles">
                <h3>Edit Roles</h3>
                <div class="user-roles">
                    <div id="display-roles">
                        <?php $info->DisplayUserTutorRoles($_GET["ID"]); ?>
                    </div>
                    <div id="button-roles">
                        <form id="roles" method="POST" name="Addroleform">
                            <input type="text" name="ID" hidden value="<?php echo $_GET["ID"]; ?>">
                            <select name="Role">
                                <?php $roles = $info->ListAllTutorRoles($_GET["ID"]); ?>
                            </select>
                            <input type="submit" value="Add Role" name="Addroleform">
                        </form>
                        <?php if($roles){echo '<script>document.getElementById("roles").style.display = "none"</script>';}?>
                    </div>
                </div>
                <h3>Edit subjects</h3>
                <div class="user-roles">
                    <div class="display-roles">
                        <?php $info->DisplayUserStaffSubjects($_GET["ID"]) ?>
                    </div>
                    <div id="button-roles">
                        <form id="subjects" method="POST">
                            <input type="text" name="ID" hidden value="<?php echo $_GET["ID"]; ?>">
                            <select name="Role">
                                <?php $roles = $info->ListAllStaffSubjects($_GET["ID"]); ?>
                            </select>
                            <input type="submit" value="Add Subject" name="Addrole">
                        </form>
                        <?php if($roles){echo '<script>document.getElementById("subjects").style.display = "none"</script>';}?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    document.getElementById("cover").style.display = "none";
    </script>
</body>

</html>