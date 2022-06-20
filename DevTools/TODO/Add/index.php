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
            function generateID3($length = 16) {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                return $randomString;
            }
            include "C:/xampp/htdocs/GibJohn/includes/cover.php";
            include "C:/xampp/htdocs/GibJohn/includes/header.php";
            include "C:/xampp/htdocs/GibJohn/includes/nav.php";
            $ID = GenerateID3();
            if($_SERVER["REQUEST_METHOD"] === "POST"){
                if ($stmt = $con->prepare('INSERT INTO m_todo(TodoID, Title, Des, StatusID) VALUES (?,?,?,?)')) {
                    $stmt->bind_param("ssss",$ID,$_POST["Title"],$_POST["Des"],$_POST["Status"]);
                    $stmt->execute();
                    $stmt->close();
                }else{
                    echo "OPS2";
                }
            }else{
                echo "OPS";
            }
        ?>
        <div id="content">
            <!-- Add Audit -->
            <div id="viewusers">
                <h1>Add TODO</h1>
                <form method="POST">
                    <input type="text" name="Title">
                    <textarea name="Des"> </textarea>
                    <select name="Status" id="">
                        <option style="background-color: #628b48ff;" value="BzKYoY6PvZKqqX99">Complete</option>
                        <option style="background-color: #ff0022ff;" value="Eya5dGvepXZWaKU8">InComplete</option>
                        <option style="background-color: #deb841ff;" value="hO9tT1Pks2BwkfIW">Inprogress</option>
                        <option style="background-color: #005d8fff;" value="EzzkEinYDk7JiloV">Broken</option>
                    </select>
                    <input type="submit">
                </form>
            </div>
        </div>
    </div>
    <script>
    document.getElementById("cover").style.display = "none";
    </script>
</body>

</html>