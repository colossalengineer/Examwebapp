<!DOCTYPE html>
<!-- Auther: TJ Navarro-Barer -->
<!-- Version: <?php include "C:/xampp/htdocs/GibJohn/includes/functions/version2.php"; ?> -->
<?php
    include "C:/xampp/htdocs/GibJohn/includes/functions.php";
    if(!$perms->HasPermByPermNameFromArray(array("H.Tutor","S.Tutor","Tutor")) || !isset($_GET["ID"]) || !isset($_GET["Count"]) ){
        $header = 'Location: /Dashboard/';
        header($header, true, 301);
    }
    $ID = CreateID();
    $newcount = $_GET["Count"] + 1;
    $temp = "T6C9DEnZUJhBc1vY";
    if($stmt = $con->prepare("INSERT INTO m_form_question(QuestionID, FormID,QuestionType,Pos) VALUES (?,?,?,?)")){
        $stmt->bind_param("ssss",$ID,$_GET["ID"],$temp,$newcount);
        $stmt->execute();
        if($stmt = $con->prepare("UPDATE `m_form` SET Noquestions= ? WHERE FormID = ?")){
            $stmt->bind_param("ss",$newcount,$_GET["ID"]);
            $stmt->execute();
            $header = 'Location: /Staff/Forms/Create/EditForm/?ID='.$_GET["ID"];
            header($header, true, 301);
        }
    }
?>