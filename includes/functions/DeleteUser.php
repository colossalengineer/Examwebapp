<?php
    /* 
        Author: TJ Navarro-barber
        File Name: DeleteUser.php
        Function: DeleteUser from database
    */
    class DeleteUser{
        public function __construct() {
            global $perms;
            global $data;
            global $audit;
            $this->safe = $data;
            $this->perm = $perms;
            $this->audit = $audit;
        }
        public function DeleteUser($type){
            if($_SERVER["REQUEST_METHOD"] === "POST"){
                $ID = $_POST["ID"];
                if($type == "Staff"){
                    $this->DeleteStaff($ID);
                }elseif($type == "Student"){
                    $this->DeleteStudents($ID);
                }else{
                    $this->DeleteParents($ID);
                }
            }
        }
        private function DeleteStaff($ID){
            global $con;
            echo $ID;
            $this->audit->addaudit("HTcbBYtmKtkbaUpk","ZNyj7NuZ8zr5VZBD",$ID,$this->perm->GetNameOfUserByID($ID));
            if ($stmt = $con->prepare('DELETE FROM m_account WHERE m_account.UserID = ?')) {
                $stmt->bind_param('s',$ID);
                $stmt->execute();
                $stmt->close();
                if ($stmt = $con->prepare('DELETE FROM m_login WHERE m_login.UserID = ?')) {
                    $stmt->bind_param('s',$ID);
                    $stmt->execute();
                    $stmt->close();
                    if ($stmt = $con->prepare('DELETE FROM m_staff_roles_assign WHERE m_staff_roles_assign.UserID = ?')) {
                        $stmt->bind_param('s',$ID);
                        $stmt->execute();
                        $stmt->close();
                        if ($stmt = $con->prepare('DELETE FROM m_staff_titles_assign WHERE m_staff_titles_assign.UserID = ?')) {
                            $stmt->bind_param('s',$ID);
                            $stmt->execute();
                            $stmt->close();
                            if ($stmt = $con->prepare('DELETE FROM m_account_settings WHERE m_account_settings.UserID = ?')) {
                                $stmt->bind_param('s',$ID);
                                $stmt->execute();
                                $stmt->close();
                                $header = 'Location: /managment/ManageStaff/';
                                header($header, true, 301);
                            }
                        }
                    }
                }
            }
        }
        private function DeleteStudents($ID){
            global $con;
            echo $ID;
            $this->audit->addaudit("aQRC3hjX01RjBsh2","ZNyj7NuZ8zr5VZBD",$ID,$this->perm->GetNameOfUserByID($ID));
            if ($stmt = $con->prepare('DELETE FROM m_account WHERE m_account.UserID = ?')) {
                $stmt->bind_param('s',$ID);
                $stmt->execute();
                $stmt->close();
                if ($stmt = $con->prepare('DELETE FROM m_login WHERE m_login.UserID = ?')) {
                    $stmt->bind_param('s',$ID);
                    $stmt->execute();
                    $stmt->close();
                    if ($stmt = $con->prepare('DELETE FROM m_student_roles_assign WHERE m_student_roles_assign.UserID = ?')) {
                        $stmt->bind_param('s',$ID);
                        $stmt->execute();
                        $stmt->close();
                        if ($stmt = $con->prepare('DELETE FROM m_staff_assign WHERE m_staff_assign.SUserID = ?')) {
                            $stmt->bind_param('s',$ID);
                            $stmt->execute();
                            $stmt->close();
                            if ($stmt = $con->prepare('DELETE FROM m_subject_assign WHERE m_subject_assign.SUserID = ?')) {
                                $stmt->bind_param('s',$ID);
                                $stmt->execute();
                                $stmt->close();
                                if ($stmt = $con->prepare('DELETE FROM m_student_overall_score WHERE m_student_overall_score.SUserID = ?')) {
                                    $stmt->bind_param('s',$ID);
                                    $stmt->execute();
                                    $stmt->close();
                                    if ($stmt = $con->prepare('DELETE FROM m_student_subject_score WHERE m_student_subject_score.SUserID = ?')) {
                                        $stmt->bind_param('s',$ID);
                                        $stmt->execute();
                                        $stmt->close();
                                        if ($stmt = $con->prepare('DELETE FROM m_account_settings WHERE m_account_settings.UserID = ?')) {
                                            $stmt->bind_param('s',$ID);
                                            $stmt->execute();
                                            $stmt->close();
                                            $header = 'Location: /managment/ManageStudents/';
                                            header($header, true, 301);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    
                }
            }
        }
        private function DeleteParents($ID){
            global $con;
            echo $ID;
            $this->audit->addaudit("aQRC3hjX01RjBsh2","ZNyj7NuZ8zr5VZBD",$ID,$this->perm->GetNameOfUserByID($ID));
            if ($stmt = $con->prepare('DELETE FROM m_account WHERE m_account.UserID = ?')) {
                $stmt->bind_param('s',$ID);
                $stmt->execute();
                $stmt->close();
                if ($stmt = $con->prepare('DELETE FROM m_login WHERE m_login.UserID = ?')) {
                    $stmt->bind_param('s',$ID);
                    $stmt->execute();
                    $stmt->close();
                    if ($stmt = $con->prepare('DELETE FROM m_parent_assign WHERE m_parent_assign.PUserID = ?')) {
                        $stmt->bind_param('s',$ID);
                        $stmt->execute();
                        $stmt->close();
                        if ($stmt = $con->prepare('DELETE FROM m_account_settings WHERE m_account_settings.UserID = ?')) {
                            $stmt->bind_param('s',$ID);
                            $stmt->execute();
                            $stmt->close();
                            $header = 'Location: /managment/ManageParents/';
                            header($header, true, 301);
                        }
                    }
                    
                }
            }
        }
    }