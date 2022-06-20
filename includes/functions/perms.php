<?php
    /* 
        Author: TJ Navarro-barber
        File Name: perms.php
        Function: manages users permissions
    */
    class perms{
        private $con;
        public function __construct(){
            global $data;
            $this->safe = $data;
        }
        // function GetUserTtitleByID($ID){
        //     if ($stmt = $con->prepare('SELECT m_roles.Name FROM m_account INNER JOIN m_roles ON m_roles.RoleID = m_account.RoleID WHERE m_account.UserID = ?')) {
        //         $stmt->bind_param('s', $ID);
        //         $stmt->execute();
        //         $stmt->store_result();
        //         if ($stmt->num_rows > 0) {
        //             $stmt->bind_result($name);
        //             $stmt->fetch();
        //             return($name);
        //         }else{
        //             return false;
        //         }
        //     }
        // }
        function GetAccountTypeIDByName($Name){
            global $con;
            if ($stmt = $con->prepare('SELECT AccountTypeID FROM m_accout_types WHERE Name = ?')) {
                $stmt->bind_param('s', $Name);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($ID);
                    $stmt->fetch();
                    return $ID;
                }else{
                    return false;
                }
            }
        }
        function GetAccountsTypeNameByID($Acounnt,$Type){
            global $con;
            if ($stmt = $con->prepare('SELECT AccountTypeID FROM m_accout_types WHERE Name = ?')) {
                $stmt->bind_param('s', $Name);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($ID);
                    $stmt->fetch();
                    return $ID;
                }else{
                    return false;
                }
            }
        }
        function GetUsersInfoByID($ID){
            global $con;
            if ($stmt = $con->prepare('SELECT m_account.FirstName, m_account.LastName, m_account.Email, m_account.Phone, m_accout_types.Name, m_login.Username FROM m_account INNER JOIN m_accout_types ON m_account.AccountTypeID = m_accout_types.AccountTypeID INNER JOIN m_login ON m_login.UserID = m_account.UserID WHERE m_account.UserID = ?')) {
                $stmt->bind_param('s', $ID);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($FN,$LN,$Email,$Phone,$AccountType,$Username);
                    $stmt->fetch();
                    $return = array($FN,$LN,$Email,$Phone,$AccountType,$Username);
                    return $return;
                }else{
                    return false;
                }
            }
        }
        function GetUsersStaffRolesByID($ID){
            global $con;
            if ($stmt = $con->prepare('SELECT m_staff_roles.Name FROM m_staff_roles_assign INNER JOIN m_staff_roles ON m_staff_roles.RoleID = m_staff_roles_assign.RoleID WHERE m_staff_roles_assign.UserID = ?')) {
                $stmt->bind_param('s', $ID);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($Role);
                    $roles = array();
                    while($row =$stmt->fetch()){
                        array_push($roles,$Role);
                    }
                    return $roles;
                }else{
                    return false;
                }
            }
        }
        function GetUsersStudentRolesByID($ID){
                global $con;
                if ($stmt = $con->prepare('SELECT m_student_roles.Name FROM m_student_roles_assign INNER JOIN m_student_roles ON m_student_roles.RoleID = m_student_roles_assign.RoleID WHERE m_student_roles_assign.UserID = ?')) {
                    $stmt->bind_param('s', $ID);
                    $stmt->execute();
                    $stmt->store_result();
                    if ($stmt->num_rows > 0) {
                        $stmt->bind_result($Role);
                        $roles = array();
                        while($row =$stmt->fetch()){
                            array_push($roles,$Role);
                        }
                        return $roles;
                    }else{
                        return false;
                    }
                }
            }
        function GetAllStaffRoles(){
            global $con;
            if ($stmt = $con->prepare('SELECT Name FROM m_staff_roles WHERE Name != "Root"')) {
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($Role);
                    $roles = array();
                    while($row = $stmt->fetch()){
                        array_push($roles,$Role);
                    }
                    return $roles;
                }else{
                    return false;
                }
            }
        }
        function GetAllStudentRoles(){
            global $con;
            if ($stmt = $con->prepare('SELECT Name FROM m_student_roles WHERE 1')) {
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($Role);
                    $roles = array();
                    while($row = $stmt->fetch()){
                        array_push($roles,$Role);
                    }
                    return $roles;
                }else{
                    return false;
                }
            }
        } 
        function HasPermByPermName($Perm){
            global $con;
            if ($stmt = $con->prepare('SELECT m_staff_roles.roleID FROM m_staff_roles INNER JOIN m_staff_roles_assign ON m_staff_roles.RoleID = m_staff_roles_assign.RoleID WHERE m_staff_roles.Name = ? AND m_staff_roles_assign.UserID = ?')) {
                $stmt->bind_param('ss',$Perm, $_SESSION["ID"]);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($name);
                    $stmt->fetch();
                    $stmt->close();
                    return true;
                }else{
                    return false;
                }
            }
        }
        function HasPermByPermNameFromArray(array $Perm){
            foreach($Perm as $i){
                if($this->HasPermByPermName($i)){
                    return true;
                }
            }
            return false;
        }
        function UserHasPermByPermName($ID,$Perm){
            global $con;
            if ($stmt = $con->prepare('SELECT m_staff_roles.roleID FROM m_staff_roles INNER JOIN m_staff_roles_assign ON m_staff_roles.RoleID = m_staff_roles_assign.RoleID WHERE m_staff_roles.Name = ? AND m_staff_roles_assign.UserID = ?')) {
                $stmt->bind_param('ss',$Perm, $ID);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($name);
                    $stmt->fetch();
                    $stmt->close();
                    return true;
                }else{
                    return false;
                }
            }
        }
        function UserHasPermByPermNameFromArray($ID,array $Perm){
            foreach($Perm as $i){
                if($this->UserHasPermByPermName($ID,$i)){
                    return true;
                }
            }
            return false;
        }
        function StudentHasPermByPermName($ID,$Perm){
            global $con;
            if ($stmt = $con->prepare('SELECT m_student_roles.roleID FROM m_student_roles INNER JOIN m_student_roles_assign ON m_student_roles.RoleID = m_student_roles_assign.RoleID WHERE m_student_roles.Name = ? AND m_student_roles_assign.UserID = ?')) {
                $stmt->bind_param('ss',$Perm, $ID);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($name);
                    $stmt->fetch();
                    $stmt->close();
                    return true;
                }else{
                    return false;
                }
            }
        }
        function GetNameOfUser(){
            global $con;
            if ($stmt = $con->prepare('SELECT  FirstName, LastName FROM m_account WHERE UserID = ?')){
                $stmt->bind_param('s',$_SESSION["ID"]);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($FN,$LN);
                    $stmt->fetch();
                    $stmt->close();
                    return $this->safe->decrypt($FN)." ".$this->safe->decrypt($LN);
                }else{
                    return $_SESSION["ID"];
                }
                
            }
        }
        function GetNameOfUserByID($ID){
            global $con;
            if ($stmt = $con->prepare('SELECT  FirstName, LastName FROM m_account WHERE UserID = ?')){
                $stmt->bind_param('s',$ID);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($FN,$LN);
                    $stmt->fetch();
                    $stmt->close();
                    return $this->safe->decrypt($FN)." ".$this->safe->decrypt($LN);
                }else{
                    return $ID;
                }
                
            }
        }
        function GetStaffPermIDByName($Perm){
            global $con;
            if ($stmt = $con->prepare('SELECT RoleID FROM m_staff_roles WHERE Name = ?')) {
                $stmt->bind_param('s', $Perm);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($ID);
                    $stmt->fetch();
                    return $ID;
                }else{
                    return false;
                }
            }return true;
        }
        function GetStudentPermIDByName($Perm){
            global $con;
            if ($stmt = $con->prepare('SELECT RoleID FROM m_student_roles WHERE Name = ?')) {
                $stmt->bind_param('s', $Perm);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($ID);
                    $stmt->fetch();
                    return $ID;
                }else{
                    return false;
                }
            }return true;
        }
        function RemoveStaffRoleFromUser($ID,$Role){
            global $con;
            $RoleID = $this->GetStaffPermIDByName($Role);
            if ($stmt = $con->prepare('DELETE FROM m_staff_roles_assign WHERE UserID = ? AND RoleID = ?')){
                $stmt->bind_param('ss',$ID,$RoleID);
                $stmt->execute();
                $stmt->close();
            }
        }
        function AddStaffRoleToUser($ID,$Role){
            global $con;
            $RoleID = $this->GetStaffPermIDByName($Role);
            var_dump($RoleID);
            echo $Role;
            echo $ID;
            if ($stmt = $con->prepare('INSERT INTO `m_staff_roles_assign`(`UserID`, `RoleID`) VALUES ( ? , ?)')){
                $stmt->bind_param('ss',$ID,$RoleID);
                $stmt->execute();
                $stmt->close();
            }
        }
        function RemoveStudentRoleFromUser($ID,$Role){
            global $con;
            $RoleID = $this->GetStudentPermIDByName($Role);
            if ($stmt = $con->prepare('DELETE FROM m_student_roles_assign WHERE UserID = ? AND RoleID = ?')){
                $stmt->bind_param('ss',$ID,$RoleID);
                $stmt->execute();
                $stmt->close();
            }
        }
        function AddStudentRoleToUser($ID,$Role){
            global $con;
            $RoleID = $this->GetStudentPermIDByName($Role);
            var_dump($RoleID);
            echo $Role;
            echo $ID;
            if ($stmt = $con->prepare('INSERT INTO `m_student_roles_assign`(`UserID`, `RoleID`) VALUES ( ? , ?)')){
                $stmt->bind_param('ss',$ID,$RoleID);
                $stmt->execute();
                $stmt->close();
            }
        }
        function GetAllStudentSubjects(){
            global $con;
            if ($stmt = $con->prepare('SELECT Name FROM m_subject WHERE 1 ORDER BY Name')) {
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($Role);
                    $roles = array();
                    while($row = $stmt->fetch()){
                        array_push($roles,$Role);
                    }
                    return $roles;
                }else{
                    return false;
                }
            }
        }
        function StudentHasSubjectbySubjectName($ID,$Perm){
            global $con;
            if ($stmt = $con->prepare('SELECT m_subject_assign.UserID FROM m_subject_assign INNER JOIN m_subject on m_subject_assign.SubjectclassID = m_subject.SubjectclassID WHERE m_subject.Name = ? AND m_subject_assign.UserID = ?')) {
                $stmt->bind_param('ss',$Perm, $ID);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($name);
                    $stmt->fetch();
                    $stmt->close();
                    return true;
                }else{
                    return false;
                }
            }
        }
        function StaffHasSubjectbySubjectName($ID,$Perm){
            global $con;
            if ($stmt = $con->prepare('SELECT m_staff_subject_assign.UserID FROM m_staff_subject_assign INNER JOIN m_subject on m_staff_subject_assign.SubjectclassID = m_subject.SubjectclassID WHERE m_subject.Name = ? AND m_staff_subject_assign.UserID = ?')) {
                $stmt->bind_param('ss',$Perm, $ID);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($name);
                    $stmt->fetch();
                    $stmt->close();
                    return true;
                }else{
                    return false;
                }
            }
        }
        function GetUsersStudentSubjectByID($ID){
            global $con;
            if ($stmt = $con->prepare('SELECT m_subject.Name FROM m_subject_assign INNER JOIN m_subject on m_subject_assign.SubjectclassID = m_subject.SubjectclassID WHERE m_subject_assign.UserID = ? ')) {
                $stmt->bind_param('s', $ID);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($Role);
                    $roles = array();
                    while($row = $stmt->fetch()){
                        array_push($roles,$Role);
                    }
                    return $roles;
                }else{
                    return false;
                }
            }
        }
        function GetUsersStaffSubjectByID($ID){
            global $con;
            if ($stmt = $con->prepare('SELECT m_subject.Name FROM m_staff_subject_assign INNER JOIN m_subject on m_staff_subject_assign.SubjectclassID = m_subject.SubjectclassID WHERE m_staff_subject_assign.UserID = ? ')) {
                $stmt->bind_param('s', $ID);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($Role);
                    $roles = array();
                    while($row = $stmt->fetch()){
                        array_push($roles,$Role);
                    }
                    return $roles;
                }else{
                    return false;
                }
            }
        }
        function GetSubjectIDByName($ID){
            global $con;
            if ($stmt = $con->prepare('SELECT SubjectclassID FROM m_subject WHERE Name =  ? ')) {
                $stmt->bind_param('s', $ID);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($Role);
                    $stmt->fetch();
                    return $Role;
                }else{
                    return false;
                }
            }
        }
        function RemoveStudentSubjectFromUser($ID,$Role){
            global $con;
            $RoleID = $this->GetSubjectIDByName($Role);
            if ($stmt = $con->prepare('DELETE FROM m_subject_assign WHERE UserID = ? AND SubjectclassID = ?')){
                $stmt->bind_param('ss',$ID,$RoleID);
                $stmt->execute();
                $stmt->close();
            }
        }
        function AddStudentSubjectToUser($ID,$Role){
            global $con;
            $RoleID = $this->GetSubjectIDByName($Role);
            if ($stmt = $con->prepare('INSERT INTO m_subject_assign(UserID, SubjectclassID) VALUES ( ? , ?)')){
                $stmt->bind_param('ss',$ID,$RoleID);
                $stmt->execute();
                $stmt->close();
            }
        }
        function RemoveStaffSubjectFromUser($ID,$Role){
            global $con;
            $RoleID = $this->GetSubjectIDByName($Role);
            if ($stmt = $con->prepare('DELETE FROM m_staff_subject_assign WHERE UserID = ? AND SubjectclassID = ?')){
                $stmt->bind_param('ss',$ID,$RoleID);
                $stmt->execute();
                $stmt->close();
            }
        }
        function AddStaffSubjectToUser($ID,$Role){
            global $con;
            $RoleID = $this->GetSubjectIDByName($Role);
            if ($stmt = $con->prepare('INSERT INTO m_staff_subject_assign(UserID, SubjectclassID) VALUES ( ? , ?)')){
                $stmt->bind_param('ss',$ID,$RoleID);
                $stmt->execute();
                $stmt->close();
            }
        }
        
        function infofromID($ID){
            global $con;
            if ($stmt = $con->prepare('SELECT  FirstName, LastName FROM m_account WHERE UserID = ?')) {
                $stmt->bind_param('s',$ID);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($FN,$LN);
                    $stmt->fetch();
                    $stmt->close();
                    return "User: ".$this->safe->decrypt($FN)." ".$this->safe->decrypt($LN);
                }else{
                    $stmt->close();
                    if ($stmt = $con->prepare('SELECT Title FROM m_form WHERE FormID = ?')) {
                        $stmt->bind_param('s',$ID);
                        $stmt->execute();
                        $stmt->store_result();
                        if ($stmt->num_rows > 0) {
                            $stmt->bind_result($FID);
                            $stmt->fetch();
                            $stmt->close();
                            return "Form: ".$this->safe->decrypt($FID);
                        }else{
                            $stmt->close();
                            if ($stmt = $con->prepare('SELECT Title FROM m_review WHERE ReviewID = ?')) {
                                $stmt->bind_param('s',$ID);
                                $stmt->execute();
                                $stmt->store_result();
                                if ($stmt->num_rows > 0) {
                                    $stmt->bind_result($RV);
                                    $stmt->fetch();
                                    $stmt->close();
                                    return "Review: ".$RV;
                                }else{
                                    if ($stmt = $con->prepare('SELECT Name FROM m_staff_roles WHERE RoleID = ?')) {
                                        $stmt->bind_param('s',$ID);
                                        $stmt->execute();
                                        $stmt->store_result();
                                        if ($stmt->num_rows > 0) {
                                            $stmt->bind_result($FID);
                                            $stmt->fetch();
                                            $stmt->close();
                                            return "Staff Role: ".$FID;
                                        }else{
                                            $stmt->close();
                                            return "Item Not Found: ".$ID;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }