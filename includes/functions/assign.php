<?php
    /* 
        Author: TJ Navarro-barber
        File Name: assign.php
        Function: Assign Users
    */
    class Assign{
        public function __construct() {
            global $perms;
            global $data;
            global $audit;
            $this->safe = $data;
            $this->perm = $perms;
            $this->audit = $audit;
        }
        public function Assign($type,$SID,$RID){
            if($type == "Student"){
                $this->AssignStudents($SID,$RID);
            }else{
                $this->AssignParents($SID,$RID);
            }
        }
        private function AssignStudents($SID,$RID){
            global $con;
            if($stmt = $con->prepare('SELECT MUserID, SUserID FROM m_staff_assign WHERE MUserID = ? AND SUserID = ?')){
                $stmt->bind_param("ss",$SID,$RID);
                $stmt->execute();
                $stmt->store_result();
                if($stmt->num_rows == 0){
                    if($stmt2 = $con->prepare('INSERT INTO m_staff_assign(MUserID, SUserID) VALUES (?,?)')){
                        $stmt2->bind_param("ss",$SID,$RID);
                        $stmt2->execute();
                        $stmt2->close();
                        $stmt->close();
                        $content = $this->perm->infofromID($RID);
                        $this->audit->Addaudit("aQRC3hjX01RjBsh2","b4uPXYjzKlTmZjLb",$SID,$content);
                        $header = 'Location: /managment/ManageTutors/Assign';
                        header($header, true, 301);
                    }
                }else{?>
                    <div class="error">This assignment has already been done</div>
                <?php }
            }
        }
        private function AssignParents($SID,$RID){
            global $con;
            if($stmt = $con->prepare('SELECT SUserID, PUserID FROM m_parent_assign WHERE SUserID = ? AND PUserID = ?')){
                $stmt->bind_param("ss",$SID,$RID);
                $stmt->execute();
                $stmt->store_result();
                if($stmt->num_rows == 0){
                    if($stmt2 = $con->prepare('INSERT INTO m_parent_assign(SUserID, PUserID) VALUES (?,?)')){
                        $stmt2->bind_param("ss",$SID,$RID);
                        $stmt2->execute();
                        $stmt2->close();
                        $stmt->close();
                        $content = $this->perm->infofromID($RID);
                        $this->audit->Addaudit("LmmhXvTBTy0fcG5V","b4uPXYjzKlTmZjLb",$SID,$content);
                        $header = 'Location: /managment/ManageTutors/Assign';
                        header($header, true, 301);
                    }
                }else{?>
                    <div class="error">This assignment has already been done</div>
                <?php }
            }
        }
        public function UnAssign($type,$SID,$RID){
            if($type == "Student"){
                $this->UnAssignStudents($SID,$RID);
            }else{
                $this->UnAssignParents($SID,$RID);
            }
        }
        private function UnAssignStudents($SID,$RID){
            global $con;
            if($stmt = $con->prepare('DELETE FROM m_staff_assign WHERE MUserID = ? AND SUserID = ?')){
                $stmt->bind_param("ss",$SID,$RID);
                $stmt->execute();
                $stmt->close();
                $content = $this->perm->infofromID($RID);
                $this->audit->Addaudit("aQRC3hjX01RjBsh2","NLhCMnk9rBYV4OS4",$SID,$content);
                $header = 'Location: /managment/ManageTutors/Assign';
                header($header, true, 301);
            }
        }
        private function UnAssignParents($SID,$RID){
            global $con;
            if($stmt = $con->prepare('DELETE FROM m_parent_assign WHERE SUserID = ? AND PUserID = ?')){
                $stmt->bind_param("ss",$SID,$RID);
                $stmt->execute();
                $stmt->close();
                $content = $this->perm->infofromID($RID);
                $this->audit->Addaudit("aQRC3hjX01RjBsh2","NLhCMnk9rBYV4OS4",$SID,$content);
                $header = 'Location: /managment/ManageParents/Assign';
                header($header, true, 301);
            }
        }
    }
