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
            if($_SERVER["REQUEST_METHOD"] === "POST"){
                if ($stmt = $con->prepare('UPDATE m_todo SET Title = ?, Des = ?, StatusID = ?  WHERE m_todo.TodoID = ?')) {
                    $stmt->bind_param("ssss",$_POST["Title"],$_POST["Des"],$_POST["Status"],$_POST["ID"]);
                    $stmt->execute();
                    $stmt->close();
                    $header = 'Location: /DevTools/TODO/';
                    header($header, true, 301);
                }
            }else{
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
            }
        ?>
        <div id="content">
            <!-- Edit Audit -->
            <div id="user-info">
                <form  method="post">
                <h3>Edit Form Info</h3>
                <input type="text" hidden name="ID" value="<?php echo $_GET["ID"] ?>">
                <input type="text" name="Title" class="item" value="<?php echo $Title ?>">
                <textarea name="Des" class="item" ><?php echo $Des ?></textarea>
                <select name="Status" id="">
                        <option style="background-color: #628b48ff;" value="BzKYoY6PvZKqqX99" <?php if($Status == "Complete"){ ?> selected <?php }?>>Complete</option>
                        <option style="background-color: #ff0022ff;" value="Eya5dGvepXZWaKU8" <?php if($Status == "InComplete"){ ?> selected <?php }?>>InComplete</option>
                        <option style="background-color: #deb841ff;" value="hO9tT1Pks2BwkfIW" <?php if($Status == "Inprogress"){ ?> selected <?php }?>>Inprogress</option>
                        <option style="background-color: #005d8fff;" value="EzzkEinYDk7JiloV"<?php if($Status == "Broken"){ ?> selected <?php }?>>Broken</option>
                </select>
                <input type="submit">
                </form>
            </div>
        </div>
    </div>
    </div>
    <script>
    document.getElementById("cover").style.display = "none";
    </script>
</body>

</html>