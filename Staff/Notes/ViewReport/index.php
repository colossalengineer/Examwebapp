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
        ?>
        <div id="content">
            <div id="user-info">
                <h3>Review Info</h3>
                <div class="item">Title: <?php echo $Title ?></div>
                <div class="item">Type: <?php if($Type == "Review"){ echo "Review"; }if($Type == "Reward"){ echo "Reward"; }if($Type == "Warning"){ echo "Warning"; }?></div>
                <div class="item">Conent: <?php echo $Content; ?></div>
            </div>
        </div>
    <script>
        document.getElementById("cover").style.display = "none";
    </script>
</body>
</html>