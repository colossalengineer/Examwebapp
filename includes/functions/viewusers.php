<?php
    class viewusers{
        public function __construct($DB_NAME="gibjohn",$DB_SERVER = "localhost",$DB_USERNAME = 'root',$DB_PASSWORD = ''){
            $this->con = mysqli_connect($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
            $this->safe = new data();
        }
        public function displayedit($type){
            
        }
    }