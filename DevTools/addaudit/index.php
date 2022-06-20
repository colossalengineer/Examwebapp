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
    $encrypt = new data();
    $audit = new audit();
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
            <!-- Add Audit -->
            <?php 
                if($_SERVER["REQUEST_METHOD"] == "POST"){
                    $audit->Addaudit($_POST["type"],$_POST["changetype"],$_POST["revID"],$_POST["cont"]);
                }else{
                    echo "input";
                }
            ?>
            <form method="POST">
                <select name="type">
                    <option value="aQRC3hjX01RjBsh2">Student</option>
                    <option value="HTcbBYtmKtkbaUpk">Staff</option>
                    <option value="LmmhXvTBTy0fcG5V">Parent</option>
                    <option value="SpsHJnd2kTvcPAfj">Form</option>
                </select>
                <select name="changetype">
                    <option value="4DJE4xKMs6Y2hwGr">Edit</option>
                    <option value="b4uPXYjzKlTmZjLb">Assign</option>
                    <option value="bucWIBqacLZ9Co6g">AddRole</option>
                    <option value="CzaEUAU0bZHQiIKh">RemoveRole</option>
                    <option value="fwFWdyghohKz87rC">Create</option>
                    <option value="NLhCMnk9rBYV4OS4">UnAssign</option>
                    <option value="ZNyj7NuZ8zr5VZBD">Delete</option>
                </select>
                <input type="text" name="revID" placeholder="ReleventID">
                <input type="text" name="cont" placeholder="Content">
                <input type="submit">
            </form>
        </div>
    </div>
    <script>
        document.getElementById("cover").style.display = "none";
    </script>
</body>

</html>