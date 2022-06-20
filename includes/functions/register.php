<?php 
    /* 
        Author: TJ Navarro-barber
        File Name: regitser.php
        Function: Creates a new user
    */
    class register{
        public $empty = false;
        public $emailval = false;
        public function __construct() {
            global $perms;
            global $data;
            global $audit;
            $this->safe = $data;
            $this->perm = $perms;
            $this->audit = $audit;
        }
        public function register(){
            global $con;
            if($_SERVER["REQUEST_METHOD"] === "POST"){
                if($_POST['Type'] == "Staff"){
                    if(is_null($_POST["FirstName"]) || is_null($_POST["LastName"]) || is_null($_POST["Email"])){
                        $this->empty = true;
                    }else{
                        echo 0.5;
                        if(filter_var($_POST["Email"], FILTER_VALIDATE_EMAIL)){
                                $username = $_POST["FirstName"][0].$_POST["LastName"].$this->generatePin(3);
                                $ID = $this->generateID();
                                $pass = $this->generatePin();
                                $hassed_passowd = password_hash($pass,PASSWORD_DEFAULT);
                                $enpass = $this->safe->encrypt($hassed_passowd);
                                $phone = $this->safe->encrypt($_POST['Phone']);
                                $email = $this->safe->encrypt($_POST['Email']);
                                $firstname = $this->safe->encrypt($_POST['FirstName']);
                                $lastname = $this->safe->encrypt($_POST['LastName']);
                                $role = $this->perm->GetAccountTypeIDByName($_POST['Type']);
                                if ($stmt1 = $con->prepare("INSERT INTO m_account(UserID, Email, FirstName, LastName, Phone, AccountTypeID) VALUES (?,?,?,?,?,?)")){
                                    $stmt1->bind_param('ssssss', $ID,$email,$firstname,$lastname,$phone,$role);
                                    if ($stmt2 = $con->prepare("INSERT INTO m_login(UserID, Username, Password) VALUES (?,?,?)")){
                                        $stmt2->bind_param('sss',$ID,$username,$enpass);
                                        if ($stmt3 = $con->prepare("INSERT INTO `m_staff_titles_assign`(`UserID`, `TitleID`) VALUES (?,?)")){
                                            $value = "P40I2yxnEy9DFc99";
                                            $stmt3->bind_param('ss',$ID,$value);
                                            $stmt1->execute();
                                            $stmt2->execute();
                                            $stmt3->execute();
                                            $this->audit->Addaudit("HTcbBYtmKtkbaUpk","fwFWdyghohKz87rC",$ID,$username);
                                            $stmt1->close();
                                            $stmt2->close();
                                            $stmt3->close();
                                            $this->audit->Addaudit("HTcbBYtmKtkbaUpk","cnBBeJqQSx0hxVuW",$ID,"New");
                                            header('Location: /Managment/ManageStaff/AddStaff/Pin/?Pin='.$pass."&username=".$username, true, 301);
                                        }
                                    }else{echo 2; }  
                                }else{
                                    echo 1;
                                }
                        }else{
                            $this->emailval = true;
                        }
                    }
                }if($_POST['Type'] == "Student"){
                    if(is_null($_POST["FirstName"]) || is_null($_POST["LastName"]) || is_null($_POST["Email"])){
                        $this->empty = true;
                    }else{
                        echo 0.5;
                        if(filter_var($_POST["Email"], FILTER_VALIDATE_EMAIL)){
                                $username = $_POST["FirstName"][0].$_POST["LastName"].$this->generatePin(3);
                                $ID = $this->generateID();
                                $pass = $this->generatePin();
                                $hassed_passowd = password_hash($pass,PASSWORD_DEFAULT);
                                $enpass = $this->safe->encrypt($hassed_passowd);
                                $phone = $this->safe->encrypt($_POST['Phone']);
                                $email = $this->safe->encrypt($_POST['Email']);
                                $firstname = $this->safe->encrypt($_POST['FirstName']);
                                $lastname = $this->safe->encrypt($_POST['LastName']);
                                $role = $this->perm->GetAccountTypeIDByName($_POST['Type']);
                                if ($stmt1 = $con->prepare("INSERT INTO m_account(UserID, Email, FirstName, LastName, Phone, AccountTypeID) VALUES (?,?,?,?,?,?)")){
                                    $stmt1->bind_param('ssssss', $ID,$email,$firstname,$lastname,$phone,$role);
                                    if ($stmt2 = $con->prepare("INSERT INTO m_login(UserID, Username, Password) VALUES (?,?,?)")){
                                        $stmt2->bind_param('sss',$ID,$username,$enpass);
                                        $stmt1->execute();
                                        $stmt2->execute();
                                        $this->audit->Addaudit("aQRC3hjX01RjBsh2","fwFWdyghohKz87rC",$ID,$username);
                                        $stmt1->close();
                                        $stmt2->close();
                                        header('Location: /Managment/ManageStudents/AddStudent/Pin/?Pin='.$pass."&username=".$username, true, 301);
                                    }else{echo 2; }  
                                }else{
                                    echo 1;
                                }
                        }else{
                            $this->emailval = true;
                        }
                    }
                }elseif($_POST['Type'] == "Parent"){
                    if(is_null($_POST["FirstName"]) || is_null($_POST["LastName"]) || is_null($_POST["Email"])){
                        $this->empty = true;
                    }else{
                        echo 0.5;
                        if(filter_var($_POST["Email"], FILTER_VALIDATE_EMAIL)){
                                $username = $_POST["FirstName"][0].$_POST["LastName"].$this->generatePin(3);
                                $ID = $this->generateID();
                                $pass = $this->generatePin();
                                $hassed_passowd = password_hash($pass,PASSWORD_DEFAULT);
                                $enpass = $this->safe->encrypt($hassed_passowd);
                                $phone = $this->safe->encrypt($_POST['Phone']);
                                $email = $this->safe->encrypt($_POST['Email']);
                                $firstname = $this->safe->encrypt($_POST['FirstName']);
                                $lastname = $this->safe->encrypt($_POST['LastName']);
                                $role = $this->perm->GetAccountTypeIDByName($_POST['Type']);
                                if ($stmt1 = $con->prepare("INSERT INTO m_account(UserID, Email, FirstName, LastName, Phone, AccountTypeID) VALUES (?,?,?,?,?,?)")){
                                    $stmt1->bind_param('ssssss', $ID,$email,$firstname,$lastname,$phone,$role);
                                    if ($stmt2 = $con->prepare("INSERT INTO m_login(UserID, Username, Password) VALUES (?,?,?)")){
                                        $stmt2->bind_param('sss',$ID,$username,$enpass);
                                        $stmt1->execute();
                                        $stmt2->execute();
                                        $this->audit->Addaudit("LmmhXvTBTy0fcG5V","fwFWdyghohKz87rC",$ID,$username);
                                        $stmt1->close();
                                        $stmt2->close();
                                        header('Location: /Managment/ManageParents/AddStudent/Pin/?Pin='.$pass."&username=".$username, true, 301);
                                    }else{echo 2; }  
                                }else{
                                    echo 1;
                                }
                        }else{
                            $this->emailval = true;
                        }
                    }
                }
            }
        }
        public function Getvalue($input)
        {
            if($_SERVER["REQUEST_METHOD"] === "POST"){
                if(isset($_POST[$input])){
                    return $_POST[$input];
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
        private function generateID($length = 16) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }
        private function generatePin($length = 4) {
            $characters = '0123456789';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }
    }