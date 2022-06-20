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
        if(!$perms->HasPermByPermNameFromArray(array("H.Tutor","S.Tutor","Tutor")) || $_GET["ID"] == ""){
            $header = 'Location: /Dashboard/';
            header($header, true, 301);
        }
        if($stmt = $con->prepare("SELECT Title, Formtype, SubjectclassID, Noquestions, Active, UserID, AssignOnly, ClosingDate FROM m_form WHERE FormID = ?")){
            $stmt->bind_param("s",$_GET["ID"]);
            $stmt->execute();
            $stmt->store_result();
            if($stmt->num_rows > 0){
                $stmt->bind_result($Title,$Type,$Subject,$NoQ,$Active,$User,$Assign,$Closing);
                $stmt->fetch();
            }
            if($stmt = $con->prepare("SELECT Name FROM m_subject WHERE SubjectclassID = ?")){
                $stmt->bind_param("s",$Subject);
                $stmt->execute();
                $stmt->store_result();
                if($stmt->num_rows > 0){
                    $stmt->bind_result($SubjectName);
                    $stmt->fetch();
                }
                
                if($stmt = $con->prepare("SELECT Name FROM m_form_type WHERE TypeID = ?")){
                    $stmt->bind_param("s",$Type);
                    $stmt->execute();
                    $stmt->store_result();
                    if($stmt->num_rows > 0){
                        $stmt->bind_result($TypeName);
                        $stmt->fetch();
                    }
                    if($stmt = $con->prepare("SELECT QuestionID FROM m_form_question WHERE FormID = ? ORDER BY Pos ASC")){
                        $stmt->bind_param("s",$_GET["ID"]);
                        $stmt->execute();
                        $stmt->store_result();
                        $Questions = array();
                        if($stmt->num_rows > 0){
                            $stmt->bind_result($QuestionID);
                            while($row = $stmt->fetch()){
                                array_push($Questions,$QuestionID);
                            }
                        }
                    }   
                }
            }
        }
    ?>
    <div id="app">
        <?php 
            include "C:/xampp/htdocs/GibJohn/includes/cover.php";
            include "C:/xampp/htdocs/GibJohn/includes/header.php";
            include "C:/xampp/htdocs/GibJohn/includes/nav.php";
            $Question = new DisplayFormQuestions();
        ?>
        <div id="content">
            <div id="View">
                <div id="main">
                    <h3>General Info</h3>
                    <p>Title: <?php echo $data->decrypt($Title); ?></p>
                    <p>Type: <?php echo $TypeName; ?></p>
                    <p>Subject: <?php echo $SubjectName; ?></p>
                    <p>NoQ: <?php echo $NoQ; ?></p>
                    <p>Created By: <?php echo $User; ?></p>
                    <p>Open: <?php if($Active){echo "Yes";}else{echo "No";} ?></p>
                    <p>Assign Only: <?php if($Assign){echo "Yes";}else{echo "No";} ?></p>
                    <p>Closing Date: <?php echo $Closing; ?></p>
                </div>
                <div>
                    <a href="/Staff/Forms/Create/EditForm/Data/?ID=<?php echo $_GET["ID"] ?>"><button disabled class="Update">Edit Main Form Info</button></a>
                    <a href="/Staff/Forms/Create/EditForm/Active/?ID=<?php echo $_GET["ID"] ?>&Status=<?php echo $Active ?>" class="<?php if($Active){echo "Active";}else{echo "NonActive";} ?>"><button class="Update"><?php if($Active){echo "Deactivate";}else{echo "Activate";} ?></button></a>
                    <a title="Delete Resourse" href="/Staff/Forms/Create/EditForm/Delete/?ID=<?php echo $_GET["ID"] ?>"><button disabled class="Delete">Delete Resourse</button></a>
                </div>
                <div id="Questions">
                    <?php
                        $count = 0;
                        foreach ($Questions as $i) {
                            $Question->DisplayQuestionInfo($i);
                        }
                    ?>
                </div>
                <div id="Add">
                    <a href="/Staff/Forms/Create/EditForm/AddQuestion/?ID=<?php echo $_GET["ID"] ?>&Count=<?php echo $NoQ ?>"><button class="Update">Add A New Question</button></a>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("cover").style.display = "none";
    </script>
</body>
</html>