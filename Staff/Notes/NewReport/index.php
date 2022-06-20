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
        if(!$perms->HasPermByPermNameFromArray(array("Tutor"))){
            $header = 'Location: /Dashboard/';
            header($header, true, 301);
        }
    ?>
    <div id="app">
        <?php
            function generateIDReview($length = 16) {
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
            if($_SERVER["REQUEST_METHOD"] === "POST"){
                $ID = generateIDReview();
                $sub = 0;
                if(isset($_POST["Submit"])){
                    $sub = 1;
                }
                if ($stmt = $con->prepare('INSERT INTO m_review (ReviewID, SUserID, ReviewType, MUserID, Title, Content, Submit) VALUES (?,?,?,?,?,?,?)')) {
                    $stmt->bind_param("sssssss",$ID,$_POST["ID"],$_POST["type"],$_SESSION["ID"],$_POST["Title"],$_POST["Content"],$sub);
                    $stmt->execute();
                    $stmt->close();
                    $audit->Addaudit("aQRC3hjX01RjBsh2","fwFWdyghohKz87rC",$ID,$perms->infofromID($_POST["ID"]));
                    $header = 'Location: /Staff/Notes/View/?ID='.$_POST["ID"];
                    header($header, true, 301);
                }

            }
        ?>
        <div id="content">
        <div id="viewusers">
                <h1>Create New Students Report</h1>
                <form method="POST">
                    <input type="text" name="ID" value="<?php echo $_GET["ID"] ?>" hidden>
                    <input type="text" name="Title" placeholder="Title">
                    <textarea name="Content" placeholder="Content" onsubmit=""></textarea>
                    <select name="type" >
                        <option value="s5BaSAXnXVuko8o4">Review</option>
                        <option value="j1ExoVQnU4FmGKmd">Reward</option>
                        <option value="9LlfZ4wbsH1nfYLr">Warning</option>
                    </select>
                    <input type="checkbox" name="Submit">Submit Report
                    <input type="submit" value="Save">
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("cover").style.display = "none";
    </script>
</body>
</html>