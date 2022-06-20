<?php
    include "C:/xampp/htdocs/GibJohn/includes/functions.php";
    $session = new session();
    $session->CheckSession();
    $audit = new audit();
    $DB_NAME = "gibjohn";$DB_SERVER = "localhost";$DB_USERNAME = 'root';$DB_PASSWORD = '';
    $con = mysqli_connect($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
    if(isset($_GET["ID"])&&isset($_GET["Status"])){
        if($_GET["Status"]){
            $NewSat = 0;
            $Temp = "Deactivated";
        }else{
            $NewSat = 1;
            $Temp = "Activated";
        }
        if ($stmt = $con->prepare('UPDATE m_login SET Activated= ? WHERE UserID = ?')) {
            $stmt->bind_param('ss',$NewSat , $_GET["ID"]);
            $stmt->execute();
            $audit->Addaudit("HTcbBYtmKtkbaUpk","c1ijgDKPFP7WL7TY",$_GET["ID"],$Temp);
            $header = 'Location: /managment/ManageStaff/';
            header($header, true, 301);
        }
    }else{
        $header = 'Location: /managment/ManageStaff/';
        header($header, true, 301);
    }