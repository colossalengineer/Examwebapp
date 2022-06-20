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
        if(!$perms->HasPermByPermNameFromArray(array("H.Tutor","S.Tutor","Tutor"))){
            $header = 'Location: /Dashboard/';
            header($header, true, 301);
        }elseif($_SERVER["REQUEST_METHOD"] == "POST"){
            if(isset($_POST["Assign"])&& $_POST["Assign"] == true){
                $assign = true;
            }else{
                $assign = false;
            }
            $ID =CreateID();
            $active = 0;
            $title = $data->encrypt($_POST["Title"]);
            if($stmt = $con->prepare("INSERT INTO m_form(FormID, Title, Formtype, SubjectclassID, Noquestions, Active, UserID, AssignOnly, ClosingDate) VALUES (?,?,?,?,?,?,?,?,?)")){
                $stmt->bind_param("sssssssss",$ID,$title,$_POST["Type"],$_POST["Subject"],$active,$active,$_SESSION["ID"],$assign,$_POST["ClosingDate"]);
                $stmt->execute();
                $audit->Addaudit("SpsHJnd2kTvcPAfj","fwFWdyghohKz87rC",$ID,$_POST["Title"]);
                $header = 'Location: /Staff/Forms/Create/EditForm/?ID='.$ID;
                header($header, true, 301);
            }
            // for($i=1;$i<($_POST["NoQ"]+1);$i++){
            //     $QID =CreateID();
            //     $QType = "T6C9DEnZUJhBc1vY";
            //     $empty = "";
            //     $no = $data->encrypt(0);
            //     if($stmt = $con->prepare("INSERT INTO m_form_question(QuestionID, FormID, QuestionType, Pos, Question, Pounts) VALUES (?,?,?,?,?,?)")){
            //         $stmt->bind_param("ssssss",$QID,$ID,$QType,$i,$empty,$no);
            //         $stmt->execute();
            //     }
            // }
        }
    ?>
    <div id="app">
        <?php 
            include "C:/xampp/htdocs/GibJohn/includes/cover.php";
            include "C:/xampp/htdocs/GibJohn/includes/header.php";
            include "C:/xampp/htdocs/GibJohn/includes/nav.php";
            $info = new DisplayUserInfo();
        ?>
        <div id="content">
            <form method="POST">
                <p>
                    <span>Title:</span>
                    <input type="text" name="Title" placeholder="Form Title">
                </p>
                <p>
                    <span>Type:</span>
                    <select name="Type" id="Type">
                        <option value="RW4pbO3KFD8TQlfc">Resource</option>
                        <option disabled value="kirFaAOrc7pUrQpn">Quiz</option>
                        <option disabled value="PCLjhkQamLIRTCjB">Form</option>
                    </select>
                </p>
                <p>
                    <span>Subject:</span>
                    <select name="Subject" id="">
                        <?php $roles = $info->ListStaffSubjects($_SESSION["ID"]); ?>
                    </select>
                </p>
                <p>
                    <span>Assign Only:</span>
                    <input disabled type="checkbox" name="Assign">
                </p>
                <p>
                    <span>ClosingDate:</span>
                    <input type="date" name="ClosingDate">
                </p>
                <input type="submit" value="Create" class="Update">
            </form>
        </div>
    </div>
    <script>
    document.getElementById("cover").style.display = "none";
    </script>
</body>

</html>