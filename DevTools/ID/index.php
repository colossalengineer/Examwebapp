<!DOCTYPE html>
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
    <div id="app">
        <?php
            // Static elements
            include "C:/xampp/htdocs/GibJohn/includes/cover.php";
            include "C:/xampp/htdocs/GibJohn/includes/header.php";
            include "C:/xampp/htdocs/GibJohn/includes/nav.php";
        ?>
        <div id="content">
            <!-- ID Generation -->
            <?php 
                if($_SERVER["REQUEST_METHOD"] == "POST"){
                    echo generateID();
                }
            ?>
            <form method="post">
                <input type="submit" value="redo">
            </form>
        </div>
    </div>
    <script>
        document.getElementById("cover").style.display = "none";
    </script>
</body>

</html>