<?php 
    /* 
        Author: TJ Navarro-barber
        File Name: login.php
        Function: Logs the user in
    */
    class login{
        public $error = false;
        public $incorrect = false;
        public $empty = false;
        public $deactive = false;
        private $con;
        public function __construct(){
            
            global $perms;
            global $data;
            global $audit;
            $this->safe = $data;
            $this->perm = $perms;
            $this->audit = $audit;
            if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["reason"])){
                echo "<script type='text/javascript'>alert('You need to login first');</script>";
            }
            if(isset( $_SESSION['loggedin'])){
                $header = 'Location: /Dashboard/';
                header($header, true, 301);
            }
        }
        public function login(){
            global $con;
            if($_SERVER["REQUEST_METHOD"] === "POST"){
                $con = $con;
                if(is_null($_POST["Username"]) || is_null($_POST["Password"])){
                    $this->empty = true;
                }else{
                    if ($stmt = $con->prepare('SELECT UserID, Password, Activated FROM m_login WHERE Username = ?')) {
                        $stmt->bind_param('s', $_POST['Username']);
                        $stmt->execute();
                        $stmt->store_result();
                        if ($stmt->num_rows > 0) {
                            $stmt->bind_result($id, $password, $acitvated);
                            $stmt->fetch();
                                if($acitvated){
                                    $pass = $this->safe->decrypt($password);
                                    if (password_verify($_POST['Password'],$pass)) {
                                        if ($stmt = $con->prepare('SELECT m_accout_types.Name FROM m_accout_types INNER JOIN m_account ON m_account.AccountTypeID = m_accout_types.AccountTypeID WHERE m_account.UserID = ?')) {
                                            $stmt->bind_param('s', $id);
                                            $stmt->execute();
                                            $stmt->store_result();
                                            if ($stmt->num_rows > 0) {
                                                $stmt->bind_result($type);
                                                $stmt->fetch();
                                                $_SESSION['loggedin'] = true;
                                                $_SESSION["logtype"] = $type;
                                                $_SESSION["ID"] = $id;
                                                $header = 'Location: /Dashboard/?type='.$type;
                                                header($header, true, 301);
                                            }else{$this->incorrect = true;}
                                        }else{$this->error = true;}
                                    }else{$this->incorrect = true;}
                                }else{$this->deactive = true;}
                        }else{$this->incorrect = true;}
                    }else{$this->error = true;}
                }
            }
        }
    }