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
        if(!$perms->HasPermByPermNameFromArray(array("H.Tutor","S.Tutor","Tutor")) || !isset($_GET["ID"])){
            $header = 'Location: /Dashboard/';
            header($header, true, 301);
        }
    ?>
    <div id="app">
        <?php 
            include "C:/xampp/htdocs/GibJohn/includes/cover.php";
            include "C:/xampp/htdocs/GibJohn/includes/header.php";
            include "C:/xampp/htdocs/GibJohn/includes/nav.php";
            if($stmt = $con->prepare("SELECT m_form_question.FormID, m_form_question.Pos, m_form_question.NoA, m_form_question_type.Name, m_form_question.Question, m_form_question.Points FROM m_form_question INNER JOIN m_form_question_type ON m_form_question.QuestionType = m_form_question_type.TypeID WHERE m_form_question.QuestionID = ?")){
                $stmt->bind_param("s",$_GET["ID"]);
                $stmt->execute();
                $stmt->store_result();
                if($stmt->num_rows > 0){
                    $stmt->bind_result($FID,$Pos,$NoA,$Type,$Question,$Points);
                    $stmt->fetch();
                }
            }
            if($Type == "Number" || $Type == "Text" || $Type == "Info"){
                if($stmt = $con->prepare("SELECT AnswerID, Responce FROM m_form_question_answers WHERE QuestionID = ?")){
                    $stmt->bind_param("s",$_GET["ID"]);
                    $stmt->execute();
                    $stmt->store_result();
                    if($stmt->num_rows > 0){
                        $stmt->bind_result($AID,$Res);
                        $stmt->fetch();
                    }else{
                        $AID = CreateID();
                        $i = 1;
                        $temp = "";
                        if($stmt = $con->prepare("INSERT INTO m_form_question_answers(AnswerID, QuestionID, Responce, Correct) VALUES (?,?,?,?)")){
                            $stmt->bind_param("ssss",$AID,$_GET["ID"],$temp,$i);
                            $stmt->execute();
                            if($stmt = $con->prepare("SELECT AnswerID, Responce FROM m_form_question_answers WHERE QuestionID = ?")){
                                $stmt->bind_param("s",$_GET["ID"]);
                                $stmt->execute();
                                $stmt->store_result();
                                if($stmt->num_rows > 0){
                                    $stmt->bind_result($AID,$Res);
                                    $stmt->fetch();
                                }
                            }
                        }
                    }
                }
            }
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                if(isset($_POST["QInfo"])){
                    if($Type != $_POST["Type"]){
                        if($stmt = $con->prepare("DELETE FROM m_form_question_answers WHERE QuestionID = ?")){
                            $stmt->bind_param("s",$AID);
                            $stmt->execute();
                        }
                    }
                    $title = $data->encrypt($_POST["Title"]);
                    if($stmt = $con->prepare("UPDATE m_form_question SET QuestionType= ? ,Pos= ?  ,Question= ? ,Points= ? WHERE QuestionID = ?")){
                        $stmt->bind_param("sssss",$_POST["Type"],$_POST["Pos"],$title,$_POST["Points"],$_GET["ID"]);
                        $stmt->execute();
                    }
                }elseif(isset($_POST["AnswerS"])){
                    if($Type == "Number" || $Type == "Text" || $Type == "Info"){
                        if($stmt = $con->prepare("UPDATE m_form_question_answers SET Responce= ? WHERE AnswerID = ?")){
                            $stmt->bind_param("ss",$_POST["Answer"],$AID);
                            $stmt->execute();
                        }
                    }
                }
                $header = 'Location: /Staff/Forms/Create/EditForm/EditQuestion/?ID='.$_GET["ID"];
                header($header, true, 301);
            }
            if($stmt = $con->prepare("SELECT Noquestions FROM m_form WHERE FormID = ?")){
                $stmt->bind_param("s",$FID);
                $stmt->execute();
                $stmt->store_result();
                if($stmt->num_rows > 0){
                    $stmt->bind_result($int);
                    $stmt->fetch();
                }
            }
            if($Question != ""){
                $Question = $data->decrypt($Question);
            }
        ?>
        <div id="content">
            <div>
                <div id="main">
                    <div><a href="/Staff/Forms/Create/EditForm/?ID=<?php echo $FID ?>"><button
                                class="Update">Back</button></a></div>
                    <form method="post">
                        <h2>Question</h2>
                        <textarea name="Title" placeholder="Question"><?php echo $Question ?></textarea>
                        <select name="Pos" id="">
                            <?php 
                                for($i=1;$i<($int + 1);$i++) {?>
                            <option value="<?php echo $i ?>" <?php if($i == $Pos){?> selected <?php } ?>>
                                <?php echo $i ?></option>
                            <?php }
                            ?>
                        </select>
                        <input type="number" name="Points" placeholder="Number of Points" value="<?php echo $Points ?>">
                        <select name="Type">
                            <optgroup label="Questions">
                                <option disabled value="2wRjFlFhzvUN48NE" <?php if($Type == "MultipleChoose"){?>
                                    selected <?php } ?>>Multiple Choose Single Select</option>
                                <option disabled value="hDXzIsURjeAAY1oa" <?php if($Type == "MultipleChoose+"){?>
                                    selected <?php } ?>>Multiple Choose Multi Select</option>
                                <option value="0ZqNGGfHlht7hWOZ" <?php if($Type == "Number"){?> selected <?php } ?>>
                                    Number</option>
                                <option disabled value="ZsW5gLSX30RIoa6W" <?php if($Type == "Text"){?> selected
                                    <?php } ?>>Text
                                </option>
                            </optgroup>
                            <optgroup label="Infomation">
                                <option disabled value="i5CKpQPrtLIH0Uwq" <?php if($Type == "Video"){?> selected
                                    <?php } ?>>Video
                                </option>
                                <option disabled value="Je0oiYp39XuZn1rp" <?php if($Type == "File"){?> selected
                                    <?php } ?>>File
                                </option>
                                <option value="jjILa2MgSaP25gLX" <?php if($Type == "Info"){?> selected <?php } ?>>Info
                                </option>
                                <option disabled value="m82Ywlcphf7Sf8NT" <?php if($Type == "Image"){?> selected
                                    <?php } ?>>Image
                                </option>
                            </optgroup>
                            <option hidden disabled value="T6C9DEnZUJhBc1vY" <?php if($Type == "Not Assigned"){?>
                                selected <?php } ?>>Not Assigned</option>
                        </select>
                        <input class="Update" type="submit" value="Save" name="QInfo">
                    </form>
                </div>
                <div class="Questions">
                    <form method="post">
                        <h2>Answer</h2>
                        <?php 
                        if($Type == "Number"){?>
                        <input type="number" name="Answer" value="<?php echo $Res ?>">
                        <?php }elseif($Type == "Text"){?>
                        <input type="text" name="Answer" value="<?php echo $Res ?>">
                        <?php }elseif($Type == "Info"){?>
                        <textarea name="Answer"><?php echo $Res ?></textarea>
                        <?php }

                    ?>
                        <input type="submit" value="Save" name="AnswerS" class="Update">
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