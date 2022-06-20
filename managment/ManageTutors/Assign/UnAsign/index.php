<?php
    include "C:/xampp/htdocs/GibJohn/includes/functions.php";
    $unassign = new Assign();
    if(isset($_GET["MID"]) && isset($_GET["SID"])){
        $unassign->UnAssign("Student",$_GET["MID"],$_GET["SID"]);
    }