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
        if(!$perm->HasPermByPermName("Dev")){
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
        ?>
        <div id="content">
            <!-- Todo List -->
        <div id="viewusers">
                <h1>TODO</h1>
                <table id="audit">
                    <tr id="head"><th>Title</th><th>Status</th><th><button class="Update" onclick="location.reload()">Update</button></th><th><a href="/DevTools/TODO/Add/"><button class="Update">AddTODO<!--<img alt="AddTODO" src="/static/images/user-plus-solid.svg">--></button></a></th></tr>
                    <?php
                        $offset = 0;
                        $next = 2;
                        $pre = 1;
                        if(isset($_GET["Page"])){
                            $offset = ($_GET["Page"] * 10) - 10;
                            if(($_GET['Page']) != 1){
                                $pre = $_GET['Page'] - 1;
                            }else{
                                $pre = $_GET['Page'];
                            }
                            $next = $_GET['Page'] + 1;
                        }
                        if ($stmt = $con->prepare('SELECT m_todo.TodoID, m_todo.Title, m_todo_status.Name, m_todo_status.Color FROM m_todo INNER JOIN m_todo_status ON m_todo_status.StatusID = m_todo.StatusID WHERE 1 ORDER BY m_todo_status.StatusID DESC LIMIT 15 OFFSET ?')) {
                            $stmt->bind_param("s",$offset);
                            $stmt->execute();
                            $stmt->store_result();
                            if ($stmt->num_rows > 0) {
                                $stmt->bind_result($ID,$title,$name,$colour);
                                while($row = $stmt->fetch()){
                                    ?><tr class="<?php echo $class; ?>" style="background-color: #<?php echo $colour ?>;">
                                        <td><?php echo $title; ?></td>
                                        <td><?php echo $name; ?></td>
                                        <td><a href="/DevTools/TODO/View/?ID=<?php echo $ID; ?>"><button class="Update">view</button></a></td>
                                        <td><a href="/DevTools/TODO/Edit/?ID=<?php echo $ID; ?>"><button class="Update">Edit</button></a></td>
                                    </tr>
                                <?php
                                }
                                    ?>
                                    <tr><td><?php if(isset($_GET["Page"]) && $_GET["Page"] != 1){ ?><a href="/DevTools/TODO/?Page=<?php echo $pre ?>"><button><img alt="PRE" src="/static/images/angles-left-solid.svg"></button></a><?php }?></td><td></td><td></td><td><?php if($stmt->num_rows == 15){ ?><a href="/DevTools/TODO/?Page=<?php echo $next ?>"><button><img alt="Next" src="/static/images/angles-right-solid.svg"></button></a><?php }?></td></tr>
                                <?php 
                                $stmt->close();
                                
                            }
                        }
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