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
            include "C:/xampp/htdocs/GibJohn/includes/cover.php";
            include "C:/xampp/htdocs/GibJohn/includes/header.php";
            include "C:/xampp/htdocs/GibJohn/includes/nav.php";
            if($_SERVER["REQUEST_METHOD"] === "POST"){
                $sub = 0;
                if(isset($_POST["Submit"])){
                    $sub = 1;
                }
                if ($stmt = $con->prepare('UPDATE m_review SET ReviewType = ?,Title = ?,Content = ?,Submit = ? WHERE ReviewID = ?')) {
                    $stmt->bind_param("sssss",$_POST["type"],$_POST["Title"],$_POST["Content"],$sub,$_POST["ID"]);
                    $stmt->execute();
                    $stmt->close();
                    $audit->Addaudit("aQRC3hjX01RjBsh2","4DJE4xKMs6Y2hwGr",$_POST["ID"],$perms->infofromID($_POST["SID"]));
                    $header = 'Location: /Staff/Notes/View/?ID='.$_POST["SID"];
                    header($header, true, 301);
                }
            }else{
                if($stmt = $con->prepare("SELECT m_review.Title, m_review.Content, m_review_type.Name, m_review.Submit, m_review.Date FROM m_review INNER JOIN m_review_type ON m_review_type.TypeID = m_review.ReviewType WHERE m_review.ReviewID = ?")){
                    $stmt->bind_param("s",$_GET["ID"]);
                    $stmt->execute();
                    $stmt->store_result();
                    if($stmt->num_rows > 0){
                        $stmt->bind_result($Title,$Content,$Type,$Status,$Date);
                        $stmt->fetch();
                        $stmt->close();
                    }
                }
            }
        ?>
        <div id="content">
        <div id="viewusers">
                <h1>Create New Students Report</h1>
                <form method="POST">
                    <input type="text" name="SID" value="<?php echo $_GET["SID"] ?>" hidden>
                    <input type="text" name="ID" value="<?php echo $_GET["ID"] ?>" hidden>
                    <input type="text" name="Title" placeholder="Title" value="<?php echo $Title; ?>">
                    <textarea name="Content" placeholder="Content" > <?php echo $Content; ?> </textarea>
                    <select name="type" >
                        <option value="s5BaSAXnXVuko8o4" <?php if($Type == "Review"){ ?> selected <?php }?>>Review</option>
                        <option value="j1ExoVQnU4FmGKmd" <?php if($Type == "Reward"){ ?> selected <?php }?>>Reward</option>
                        <option value="9LlfZ4wbsH1nfYLr" <?php if($Type == "Warning"){ ?> selected <?php }?>>Warning</option>
                    </select>
                    <input type="checkbox" name="Submit" <?php if($Status){?> checked<?php }?>>Submit Report
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
