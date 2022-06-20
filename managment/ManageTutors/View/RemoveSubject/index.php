<!-- ?ID=Psf3h8LZr6OwJ1N7&Role=Dev -->
<?php
    include "C:/xampp/htdocs/GibJohn/includes/functions.php";
    $session->CheckSession();
    if(!$perms->HasPermByPermNameFromArray(array("TutorP"))){
            $header = 'Location: /Dashboard/';
            header($header, true, 301);
    }
    if(isset($_GET["ID"])&&isset($_GET["Role"])){
        $perms->RemoveStaffSubjectFromUser($_GET["ID"],$_GET["Role"]);
        $audit->Addaudit("HTcbBYtmKtkbaUpk","CfJnXgPV2DLFLRZd",$_GET["ID"],$_GET["Role"]);
        $header = 'Location: /managment/ManageTutors/View/?ID='.$_GET["ID"];
        header($header, true, 301);
    }else{
        $header = 'Location: /managment/ManageTutors/';
        header($header, true, 301);
    }