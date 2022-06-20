
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
            <!-- Add Subject -->
            <?php
                function generateID2($length = 16) {
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $charactersLength = strlen($characters);
                    $randomString = '';
                    for ($i = 0; $i < $length; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                    }
                    return $randomString;
                }
                function GetStudentSingleSubjectBYID(){
                    global $con;
                    if($stmt = $con->prepare("SELECT m_subject_id.Name , m_subject_level_id.Name FROM m_subject_id JOIN m_subject_level_id WHERE m_subject_id.SubjectID = ? AND m_subject_level_id.LevelID = ?")){
                        $stmt->bind_param("ss",$_POST["Subject"],$_POST["Level"]);
                        $stmt->execute();
                        $stmt->store_result();
                        $stmt->bind_result($SID,$LID);
                        $stmt->fetch();
                        $stmt->close();
                        return $SID." ".$LID;
                    }
                }
                if($_SERVER["REQUEST_METHOD"] == "POST"){
                    $ID = GenerateID2();
                    $input = GetStudentSingleSubjectBYID();
                    if($stmt = $con->prepare("INSERT INTO m_subject(SubjectclassID, SubjectID, Name, LevelID) VALUES (?,?,?,?)")){
                        $stmt->bind_param("ssss",$ID,$_POST["Subject"],$input,$_POST["Level"]);
                        $stmt->execute();
                        $stmt->close();
                    }
                    //INSERT INTO `m_subject`(`SubjectclassID`, `SubjectID`, `Name`, `LevelID`) VALUES ('V2ErQGx4Qm5qr4e9','fDKAP00vOBoxMcR3','English Lang KS1','jiXyNyEsreTkocBY')
                }else{
                    echo "input";
                }
            ?>
            <form method="POST">
                <select name="Subject">
                    <?php 
                        if($stmt = $con->prepare("SELECT SubjectID, Name FROM m_subject_id WHERE 1")){
                            $stmt->execute();
                            $stmt->store_result();
                            if($stmt->num_rows > 0){
                                $stmt->bind_result($ID,$Subject);
                                while($row = $stmt->fetch()){?>
                                    <option value="<?php echo $ID ?>" <?php if(isset($_POST["Level"]) && $_POST["Subject"] == $ID){echo "selected"; } ?>><?php echo $Subject ?></option>
                                <?php }
                            }
                            $stmt->close();
                        }
                    ?>
                </select>
                <select name="Level">
                    <?php 
                        if($stmt = $con->prepare("SELECT LevelID, Name FROM m_subject_level_id WHERE 1")){
                            $stmt->execute();
                            $stmt->store_result();
                            if($stmt->num_rows > 0){
                                $stmt->bind_result($ID,$Subject);
                                while($row = $stmt->fetch()){?>
                                    <option value="<?php echo $ID ?>" <?php if(isset($_POST["Level"]) && $_POST["Level"] == $ID){echo "selected"; } ?>><?php echo $Subject ?></option>
                                <?php }
                            }$stmt->close();
                        }
                    ?>
                </select>
                <input type="submit">
            </form>
        </div>
    </div>
    <script>
        document.getElementById("cover").style.display = "none";
    </script>
</body>

</html>