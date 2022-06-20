<?php
    include "C:/xampp/htdocs/GibJohn/includes/functions.php";
    $session = new session();
    $session->logout();
    $session->CheckSession();