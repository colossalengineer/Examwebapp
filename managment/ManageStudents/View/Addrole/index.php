<!-- ?ID=Psf3h8LZr6OwJ1N7&Role=Dev -->
<?php
    include "C:/xampp/htdocs/GibJohn/includes/functions.php";
    $session->CheckSession();
    if(!$perms->HasPermByPermNameFromArray(array("root","S.Management","H.Management"))){
        $header = 'Location: /Dashboard/';
        header($header, true, 301);
    }
    if(isset($_GET["ID"])&&isset($_GET["Role"])){
        $perms->AddStudentRoleToUser($_GET["ID"],$_GET["Role"]);
        $audit->Addaudit("aQRC3hjX01RjBsh2","bucWIBqacLZ9Co6g",$_GET["ID"],$_GET["Role"]);
        $header = 'Location: /managment/ManageStudents/View/?ID='.$_GET["ID"];
        header($header, true, 301);
    }else{
        $header = 'Location: /managment/ManageStudents/';
        header($header, true, 301);
    }