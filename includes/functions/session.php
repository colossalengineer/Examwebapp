<?php
    /* 
        Author: TJ Navarro-barber
        File Name: session.php
        Function: Handles sessions
    */
    class session{
        public function __construct(){
            session_start();
        }
        public function redirect(){
            if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
                $uri = 'https://';
            } else {
                $uri = 'http://';
            }
            return $uri .= $_SERVER['HTTP_HOST'];
        }
        public function CheckSession(){
            if(!isset($_SESSION["loggedin"])){
                header('Location: /?reason=NTL');
            }
        }
        public function logout(){
            session_destroy();
            header('Location: /',true,301);
        }
    }