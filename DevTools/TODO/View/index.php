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
        // General Functions
        include "C:/xampp/htdocs/GibJohn/includes/functions.php";
        include "C:/xampp/htdocs/GibJohn/includes/functions/DisplayUser.php";
        // Check permissions
        $perm = new perms();
        if(!$perm->HasPermByPermName("Dev") || !isset($_GET["ID"])){
            $header = 'Location: /Dashboard/';
            header($header, true, 301);
        }

    ?>
    <div id="app">
        <?php 
            // Static elements
            include "C:/xampp/htdocs/GibJohn/includes/cover.php";
            include "C:/xampp/htdocs/GibJohn/includes/header.php";
            include "C:/xampp/htdocs/GibJohn/includes/nav.php";
            if($stmt = $con->prepare("SELECT m_todo.Title, m_todo.Des, m_todo_status.Name FROM m_todo INNER JOIN m_todo_status ON m_todo_status.StatusID = m_todo.StatusID WHERE m_todo.TodoID = ?")){
                $stmt->bind_param("s",$_GET["ID"]);
                $stmt->execute();
                $stmt->store_result();
                if($stmt->num_rows > 0){
                    $stmt->bind_result($Title,$Des,$Status);
                    $stmt->fetch();
                    $stmt->close();
                }
            }
        ?>
        <div id="content">
            <!-- View Audit -->
            <div id="user-info">
                <h3>Form Info</h3>
                <div class="item">Title: <?php echo $Title ?></div>
                <div class="item">Description: <?php echo $Des ?></div>
                <div class="item">Status: <?php echo $Status ?></div>
            </div>
        </div>
    </div>
    <script>
    document.getElementById("cover").style.display = "none";
    </script>
</body>

</html>