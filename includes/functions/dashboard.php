<?php
    /* 
        Author: TJ Navarro-barber
        File Name:dashboard .php
        Function: Display Correct dashboard
    */
    class dashboard{
        public function __construct($per = null) {
            if($per == "Dev"){
                $dash = new Devdash();
                $dash->display();
            }elseif($per == "Games"){
                include "C:/xampp/htdocs/GibJohn/includes/Comming_soon.php";
            }elseif($_SESSION["logtype"] == "Staff"){
                $dash = new Staffdash();
                $dash->display();
            }elseif($_SESSION["logtype"] == "parent"){
            }else{
                $dash = new Studentdash();
                $dash->display();
            }
        }
    }