<?php
    /* 
        Author: TJ Navarro-barber
        File Name: version2.php
        Function: displays version to the screen
    */
    $json = file_get_contents("C:/xampp/htdocs/GibJohn/Version/version.txt");
    echo "Version: ".$json;
?>