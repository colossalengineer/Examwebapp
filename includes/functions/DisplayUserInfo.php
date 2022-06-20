<?php
    /* 
        Author: TJ Navarro-barber
        File Name: DisplayUserInfo.php
        Function: Displays Users Infomation
    */
    class DisplayUserInfo{
        public function __construct() {
            global $perms;
            global $data;
            global $audit;
            $this->safe = $data;
            $this->perm = $perms;
            $this->audit = $audit;
        }
        public function Check($item,array $arry){
            foreach($arry as $i)
                if($item == $i){
                    return true;
                }
            return false;
        }
        public function DisplayUsername($ID){
            echo $this->perm->GetNameOfUserByID($ID);
        }
        public function DisplayUserInfo($ID){
            $results = $this->perm->GetUsersInfoByID($ID);
            $FN = $results[0];
            $LN = $results[1];
            $Email = $results[2];
            $Phone = $results[3];
            $AccountType = $results[4];
            $UserName = $results[5];
            ?>
            <div class="item">AccountType: <?php echo $AccountType; ?></div>
            <div class="item">Fist Name: <?php echo $this->safe->decrypt($FN); ?></div>
            <div class="item">Last Name: <?php echo $this->safe->decrypt($LN); ?></div>
            <div class="item">Email: <?php echo $this->safe->decrypt($Email); ?></div>
            <div class="item">Phone: <?php echo $this->safe->decrypt($Phone); ?></div>
            <div class="item">Username: <?php echo $UserName; ?></div>
        <?php }
        public function DisplayUserStaffRoles($ID){
            $results = $this->perm->GetUsersStaffRolesByID($ID);
            if($results != false){
                foreach($results as $role){ 
                    $remove = false;
                    if($role != "Root" && ($role != "EditSelf" || $this->perm->HasPermByPermNameFromArray(array("Root")))){
                        if(($this->perm->HasPermByPermNameFromArray(array("Root","S.Management"))&& $this->check($role,array("H.Tutor","S.Management","M.Management","H.Management","Dev","Audit","Tutor"))) || ($this->perm->HasPermByPermNameFromArray(array("Root")) && $this->check($role,array("EditSelf")) ) ){
                            $remove = true;
                        }
                ?>
                    <div class="role"><?php if($remove){ ?><a href="/managment/ManageStaff/View/RemoveRole/?ID=<?php echo $ID; ?>&Role=<?php echo $role; ?>"><button></button></a><?php } ?><span><?php echo $role; ?></span></div>
                <?php }}
            }
        }
        public function DisplayUserTutorRoles($ID){
            $results = $this->perm->GetUsersStaffRolesByID($ID);
            if($results != false){
                foreach($results as $role){ 
                    $remove = false;
                    if($role != "Root" && ($role != "EditSelf")){
                        if(($this->perm->HasPermByPermNameFromArray(array("H.Tutor","S.Tutor"))&& $this->check($role,array("S.Tutor","TutorP","Tutor","PTutor","L.Tutor"))) || ($this->perm->HasPermByPermNameFromArray(array("Root")) && $this->check($role,array("EditSelf")) ) ){
                            $remove = true;
                        }
                ?>
                    <div class="role"><?php if($remove){ ?><a href="/managment/ManageTutors/View/RemoveRole/?ID=<?php echo $ID; ?>&Role=<?php echo $role; ?>"><button></button></a><?php } ?><span><?php echo $role; ?></span></div>
                <?php }}
            }
        }
        public function DisplayUserStudentRoles($ID){
            $results = $this->perm->GetUsersStudentRolesByID($ID);
            if($results != false){
                foreach($results as $role){ 
                ?>
                    <div class="role"><a href="/managment/ManageStudents/View/RemoveRole/?ID=<?php echo $ID; ?>&Role=<?php echo $role; ?>"><button></button></a><span><?php echo $role; ?></span></div>
                <?php }
            }
        }
        public function ListAllStaffRoles($ID){
            $results = $this->perm->GetAllStaffRoles();
            $len =  0;
            foreach($results as $i){
                if(!$this->perm->UserHasPermByPermName($ID,$i) && ($this->check($i,array("H.Tutor","S.Management","M.Management","H.Management","Dev","Audit","EditSelf","Tutor")))){$len ++;
            ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php }
            }
            if($len != 0){
                return false;
            }else{
                return true;
            }
        }
        public function ListAllTutorRoles($ID){
            $results = $this->perm->GetAllStaffRoles();
            $len =  0;
            foreach($results as $i){
                if(!$this->perm->UserHasPermByPermName($ID,$i) && $this->check($i,array("S.Tutor","TutorP","Tutor","PTutor","L.Tutor"))){$len ++;
            ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php }
            }
            if($len != 0){
                return false;
            }else{
                return true;
            }
        }
        public function ListAllStudentRoles($ID){
            $results = $this->perm->GetAllStudentRoles();
            $len =  0;
            foreach($results as $i){
                if(!$this->perm->StudentHasPermByPermName($ID,$i)){$len ++;
            ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php }
            }
            if($len != 0){
                return false;
            }else{
                return true;
            }
        }
        public function ListAllStudentSubjects($ID){
            $results = $this->perm->GetAllStudentSubjects();
            $len =  0;
            foreach($results as $i){
                if(!$this->perm->StudentHasSubjectbySubjectName($ID,$i)){$len ++;
            ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php }
            }
            if($len != 0){
                return false;
            }else{
                return true;
            }
        }
        public function DisplayUserStudentSubjects($ID){
            $results = $this->perm->GetUsersStudentSubjectByID($ID);
            if($results != false){
                foreach($results as $role){ 
                ?>
                    <div class="role"><a href="/managment/ManageStudents/View/RemoveSubject/?ID=<?php echo $ID; ?>&Role=<?php echo $role; ?>"><button></button></a><span><?php echo $role; ?></span></div>
                <?php }
            }
        }
        public function ListAllStaffSubjects($ID){
            $results = $this->perm->GetAllStudentSubjects();
            $len =  0;
            foreach($results as $i){
                if(!$this->perm->StaffHasSubjectbySubjectName($ID,$i)){$len ++;
            ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php }
            }
            if($len != 0){
                return false;
            }else{
                return true;
            }
        }
        public function DisplayUserStaffSubjects($ID){
            $results = $this->perm->GetUsersStaffSubjectByID($ID);
            if($results != false){
                foreach($results as $role){ 
                ?>
                    <div class="role"><a href="/managment/ManageTutors/View/RemoveSubject/?ID=<?php echo $ID; ?>&Role=<?php echo $role; ?>"><button></button></a><span><?php echo $role; ?></span></div>
                <?php }
            }
        }
        public function ListStaffSubjects($ID){
            $results = $this->perm->GetAllStudentSubjects();
            $len =  0;
            foreach($results as $i){
                if($this->perm->StaffHasSubjectbySubjectName($ID,$i)){$len ++;
            ?>
                    <option value="<?php echo $this->perm->GetSubjectIDByName($i); ?>"><?php echo $i; ?></option>
            <?php }
            }
            if($len != 0){
                return false;
            }else{
                return true;
            }
        }
    }