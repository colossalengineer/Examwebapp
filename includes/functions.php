<?php
    // Functions

    // Creating a 16 charater ID
    function CreateID($length = 16) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    $con = mysqli_connect("localhost","root","","gibjohn");
    // Sessions
    include "C:/xampp/htdocs/GibJohn/includes/functions/session.php";
    $session = new session();
    // Encryption
    include "C:/xampp/htdocs/GibJohn/includes/functions/Encryption.php";
    $data = new data();
    // Roles mangement
    include "C:/xampp/htdocs/GibJohn/includes/functions/perms.php";
    $perms = new perms();
    // Audit Log
    include "C:/xampp/htdocs/GibJohn/includes/functions/audit.php";
    $audit = new audit();
    // Display Users
    include "C:/xampp/htdocs/GibJohn/includes/functions/Displayusers.php";
    include "C:/xampp/htdocs/GibJohn/includes/functions/DisplayusersAssign.php";
    include "C:/xampp/htdocs/GibJohn/includes/functions/DisplayUserInfo.php";
    include "C:/xampp/htdocs/GibJohn/includes/functions/listusers.php";
    // Manipulating Users
    include "C:/xampp/htdocs/GibJohn/includes/functions/login.php";
    include "C:/xampp/htdocs/GibJohn/includes/functions/register.php";
    include "C:/xampp/htdocs/GibJohn/includes/functions/DeleteUser.php";
    // Dashboard
    include "C:/xampp/htdocs/GibJohn/includes/functions/dashboard.php";
    include "C:/xampp/htdocs/GibJohn/includes/functions/Devdash.php";
    include "C:/xampp/htdocs/GibJohn/includes/functions/staffdash.php";
    include "C:/xampp/htdocs/GibJohn/includes/functions/studentdash.php";
    // Displaying Forms
    include "C:/xampp/htdocs/GibJohn/includes/functions/DisplayFormQuestions.php";
    include "C:/xampp/htdocs/GibJohn/includes/functions/DisplayForms.php";
    // Misc
    include "C:/xampp/htdocs/GibJohn/includes/functions/assign.php";
    include "C:/xampp/htdocs/GibJohn/includes/functions/DisplayReports.php";
    // Version
    include "C:/xampp/htdocs/GibJohn/includes/functions/version.php";
    