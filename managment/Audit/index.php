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
        if(!$perm->HasPermByPermName("Root")&&!$perm->HasPermByPermName("Audit")){
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
            <div id="auditcon">
                <h1>Audit Log</h1>
                <table id="auditlog">
                    <?php $audit = new audit(); ?>
                    <tr id="head"><th>First Name</th><th>Last Name</th><th><select><option>All</option></select></th><th><select><option>All</option></select></th><th>ReleventID</th><th>Content</th><th>time</th></tr>
                    <?php 
                        $audit->DisplayAuditLog()
                    ?>
                </table>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("cover").style.display = "none";
    </script>
</body>
</html>