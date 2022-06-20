<?php
    /* 
        Author: TJ Navarro-barber
        File Name: Displayusers.php
        Function: Displays Table of Users
    */
    class DisplayUsers{
        public function __construct() {
            global $perms;
            global $data;
            global $Manage;
            $this->safe = $data;
            $this->perm = $perms;
            $this->Manage = $Manage;
        }
        public function DisplayUsers($type){
            if($type == "Staff"){
                $this->DisplayStaff();
            }elseif($type == "Tutors"){
                $this->DisplayTutors();
            }elseif($type == "Student"){
                $this->DisplayStudents();
            }else{
                $this->DisplayParents();
            }
        }
        private function DisplayStaff(){
            global $con;
            $offset = 0;$next = 2; $pre = 1;
            if(isset($_GET["Page"])){
                $offset = ($_GET["Page"] * 10) - 10;
                if(($_GET['Page']) != 1){
                    $pre = $_GET['Page'] - 1;
                }else{
                    $pre = $_GET['Page'];
                }
                $next = $_GET['Page'] + 1;
            }
            $ID = "";$Email = "";$FN = "";$LN = "";$Title = "";$active = "";
            if ($stmt = $con->prepare('SELECT m_account.UserID, m_account.Email, m_account.FirstName, m_account.LastName, m_staff_titles.Name, m_login.Activated FROM m_account INNER JOIN m_staff_titles_assign ON m_staff_titles_assign.UserID = m_account.UserID INNER JOIN m_staff_titles ON m_staff_titles_assign.TitleID = m_staff_titles.TitleID INNER JOIN m_login ON m_login.UserID = m_account.UserID WHERE m_account.AccountTypeID = "TeuZ9FYleJIo4ZKG" LIMIT 15 OFFSET ?')) {
                $stmt->bind_param("s",$offset);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($ID,$Email,$FN,$LN,$Title,$active);
                    while($row = $stmt->fetch()){
                        if($this->safe->decrypt($FN) != "Root" && ($ID != $_SESSION["ID"] || $this->perm->UserHasPermByPermName($ID,"EditSelf"))){
                        if($active){
                            $class = "Active";
                        }else{
                            $class = "NonActive";
                        }
                        ?><tr class="<?php echo $class; ?>">
                            <td><?php echo $this->safe->decrypt($FN); ?></td>
                            <td><?php echo $this->safe->decrypt($LN); ?></td>
                            <td><?php echo $this->safe->decrypt($Email); ?></td>
                            <td><?php echo $Title; ?></td>
                            <td><a href="/managment/ManageStaff/Active/?ID=<?php echo $ID; ?>&Status=<?php echo $active?>"><button><?php if($active){echo "Deactivate";}else{echo "Activate";} ?></button></a></td>
                            <td><a href="/managment/ManageStaff/View/?ID=<?php echo $ID; ?>"><button class="Update">view</button></a></td>
                            <td><a href="/managment/ManageStaff/DeleteUser/?ID=<?php echo $ID; ?>"><button class="Delete">Delete</button></a></td>
                        </tr>
                    <?php
                    }}
                    ?>
                    <tr><td><?php if(isset($_GET["Page"]) && $_GET["Page"] != 1){ ?><a href="/managment/ManageStaff/?Page=<?php echo $pre; ?>"><button><img alt="PRE" src="/static/images/angles-left-solid.svg"></button></a><?php } ?></td><td></td><td></td><td></td><td></td><td></td><td><?php if($stmt->num_rows == 15){ ?><a href="/managment/ManageStaff/?Page=<?php echo $next ?>"><button><img alt="Next" src="/static/images/angles-right-solid.svg"></button></a><?php } ?></td></tr>
                    <?php 
                    $stmt->close();
                }
            }
        }
        private function DisplayTutors(){
            global $con;
            $offset = 0;$next = 2; $pre = 1;
            if(isset($_GET["Page"])){
                $offset = ($_GET["Page"] * 10) - 10;
                if(($_GET['Page']) != 1){
                    $pre = $_GET['Page'] - 1;
                }else{
                    $pre = $_GET['Page'];
                }
                $next = $_GET['Page'] + 1;
            }
            $ID = "";$Email = "";$FN = "";$LN = "";$Title = "";$active = "";
            if ($stmt = $con->prepare('SELECT m_account.UserID, m_account.Email, m_account.FirstName, m_account.LastName, m_staff_titles.Name, m_login.Activated FROM m_account INNER JOIN m_staff_titles_assign ON m_staff_titles_assign.UserID = m_account.UserID INNER JOIN m_staff_titles ON m_staff_titles_assign.TitleID = m_staff_titles.TitleID INNER JOIN m_login ON m_login.UserID = m_account.UserID WHERE m_account.AccountTypeID = "TeuZ9FYleJIo4ZKG" LIMIT 15 OFFSET ?')) {
                $stmt->bind_param("s",$offset);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($ID,$Email,$FN,$LN,$Title,$active);
                    while($row = $stmt->fetch()){
                        if((!$this->perm->UserHasPermByPermName($ID,"Root") && ($this->perm->UserHasPermByPermNameFromArray($ID,array("Tutor","TutorP","S.Tutor","H.Tutor")) )) ){
                        if($active){
                            $class = "Active";
                        }else{
                            $class = "NonActive";
                        }
                        ?><tr class="<?php echo $class; ?>">
                            <td><?php echo $this->safe->decrypt($FN); ?></td>
                            <td><?php echo $this->safe->decrypt($LN); ?></td>
                            <td><?php echo $this->safe->decrypt($Email); ?></td>
                            <td><?php echo $Title; ?></td>
                            <td><a href="/managment/ManageTutors/Active/?ID=<?php echo $ID; ?>&Status=<?php echo $active?>"><button><?php if($active){echo "Deactivate";}else{echo "Activate";} ?></button></a></td>
                            <td><a href="/managment/ManageTutors/View/?ID=<?php echo $ID; ?>"><button class="Update">view</button></a></td>
                        </tr>
                    <?php
                    }
                    }
                        ?>
                        <tr><td><?php if(isset($_GET["Page"]) && $_GET["Page"] != 1){ ?><a href="/managment/ManageTutors/?Page=<?php echo $pre ?>"><button><img alt="PRE" src="/static/images/angles-left-solid.svg"></button></a><?php } ?></td><td></td><td></td><td></td><td></td><td><?php if($stmt->num_rows == 15){ ?><a href="/managment/ManageTutors/?Page=<?php echo $next ?>"><button><img alt="Next" src="/static/images/angles-right-solid.svg"></button></a><?php } ?></td></tr>
                        <?php  
                    $stmt->close();
                }
            }
        }
        private function DisplayStudents(){
            global $con;
            $offset = 0;$next = 2; $pre = 1;
            if(isset($_GET["Page"])){
                $offset = ($_GET["Page"] * 10) - 10;
                if(($_GET['Page']) != 1){
                    $pre = $_GET['Page'] - 1;
                }else{
                    $pre = $_GET['Page'];
                }
                $next = $_GET['Page'] + 1;
            }
            $ID = "";$Email = "";$FN = "";$LN = "";$active = "";
            if ($stmt = $con->prepare('SELECT m_account.UserID, m_account.Email, m_account.FirstName, m_account.LastName, m_account.Phone, m_login.Activated FROM m_account INNER JOIN m_login ON m_login.UserID = m_account.UserID WHERE m_account.AccountTypeID = "1M68hk3CBfFx0deu" LIMIT 15 OFFSET ?')) {
                $stmt->bind_param("s",$offset);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($ID,$Email,$FN,$LN,$Phone,$active);
                    while($row = $stmt->fetch()){
                        if($active){
                            $class = "Active";
                        }else{
                            $class = "NonActive";
                        }
                        ?><tr class="<?php echo $class; ?>">
                            <td><?php echo $this->safe->decrypt($FN); ?></td>
                            <td><?php echo $this->safe->decrypt($LN); ?></td>
                            <td><?php echo $this->safe->decrypt($Email); ?></td>
                            <td><?php echo $this->safe->decrypt($Phone); ?></td>
                            <td><a href="/managment/ManageStudents/Active/?ID=<?php echo $ID; ?>&Status=<?php echo $active?>"><button><?php if($active){echo "Deactivate";}else{echo "Activate";} ?></button></a></td>
                            <td><a href="/managment/ManageStudents/View/?ID=<?php echo $ID; ?>"><button class="Update">view</button></a></td>
                            <td><a href="/managment/ManageStudents/DeleteUser/?ID=<?php echo $ID; ?>"><button class="Delete">Delete</button></a></td>
                        </tr>
                    <?php
                    }
                        ?>
                        <tr><td><?php if(isset($_GET["Page"]) && $_GET["Page"] != 1){ ?><a href="/managment/ManageStudents/?Page=<?php echo $pre ?>"><button><img alt="PRE" src="/static/images/angles-left-solid.svg"></button></a><?php } ?></td><td></td><td></td><td></td><td></td><td></td><td><?php if($stmt->num_rows == 15){ ?><a href="/managment/ManageStudents/?Page=<?php echo $next ?>"><button><img alt="Next" src="/static/images/angles-right-solid.svg"></button></a><?php } ?></td></tr>
                        <?php 
                    $stmt->close();
                    
                }
            }
        }
        private function DisplayParents(){
            global $con;
            $offset = 0;$next = 2; $pre = 1;
            if(isset($_GET["Page"])){
                $offset = ($_GET["Page"] * 10) - 10;
                if(($_GET['Page']) != 1){
                    $pre = $_GET['Page'] - 1;
                }else{
                    $pre = $_GET['Page'];
                }
                $next = $_GET['Page'] + 1;
            }
            $ID = "";$Email = "";$FN = "";$LN = "";$active = "";
            if ($stmt = $con->prepare('SELECT m_account.UserID, m_account.Email, m_account.FirstName, m_account.LastName, m_account.Phone, m_login.Activated FROM m_account INNER JOIN m_login ON m_login.UserID = m_account.UserID WHERE m_account.AccountTypeID = "g9VGZTnkZuXjk6qs" LIMIT 15 OFFSET ?')) {
                $stmt->bind_param("s",$offset);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($ID,$Email,$FN,$LN,$Phone,$active);
                    while($row = $stmt->fetch()){
                        if($active){
                            $class = "Active";
                        }else{
                            $class = "NonActive";
                        }
                        ?><tr class="<?php echo $class; ?>">
                            <td><?php echo $this->safe->decrypt($FN); ?></td>
                            <td><?php echo $this->safe->decrypt($LN); ?></td>
                            <td><?php echo $this->safe->decrypt($Email); ?></td>
                            <td><?php echo $this->safe->decrypt($Phone); ?></td>
                            <td><a href="/managment/ManageParents/Active/?ID=<?php echo $ID; ?>&Status=<?php echo $active?>"><button><?php if($active){echo "Deactivate";}else{echo "Activate";} ?></button></a></td>
                            <td><a href="/managment/ManageParents/View/?ID=<?php echo $ID; ?>"><button class="Update">view</button></a></td>
                            <td><a href="/managment/ManageParents/DeleteUser/?ID=<?php echo $ID; ?>"><button class="Delete">Delete</button></a></td>
                        </tr>
                    <?php
                    }

                        ?>
                        <tr><td><?php if(isset($_GET["Page"]) && $_GET["Page"] != 1){ ?><a href="/managment/ManageParents/?Page=<?php echo $pre ?>"><button><img alt="PRE" src="/static/images/angles-left-solid.svg"></button></a><?php } ?></td><td></td><td></td><td></td><td></td><td></td><td><?php if($stmt->num_rows == 15){ ?><a href="/managment/ManageParents/?Page=<?php echo $next ?>"><button><img alt="Next" src="/static/images/angles-right-solid.svg"></button></a><?php } ?></td></tr>
                        <?php 

                    $stmt->close();
                    
                }
            }
        }
        function ViewStudents(){
            global $con;
            $offset = 0;$next = 2; $pre = 1;
            if(isset($_GET["Page"])){
                $offset = ($_GET["Page"] * 10) - 10;
                if(($_GET['Page']) != 1){
                    $pre = $_GET['Page'] - 1;
                }else{
                    $pre = $_GET['Page'];
                }
                $next = $_GET['Page'] + 1;
            }
            $ID = "";$Email = "";$FN = "";$LN = "";$active = "";
            if ($stmt = $con->prepare('SELECT m_account.UserID, m_account.Email, m_account.FirstName, m_account.LastName, m_account.Phone, m_login.Activated FROM m_account INNER JOIN m_login ON m_login.UserID = m_account.UserID INNER JOIN m_staff_assign ON m_staff_assign.SUserID = m_account.UserID WHERE m_account.AccountTypeID = "1M68hk3CBfFx0deu" AND m_staff_assign.MUserID = ? LIMIT 15 OFFSET ?')) {
                $stmt->bind_param("ss",$_SESSION["ID"],$offset);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($ID,$Email,$FN,$LN,$Phone,$active);
                    while($row = $stmt->fetch()){
                        if($active){
                            $class = "Active";
                        }else{
                            $class = "NonActive";
                        }
                        ?><tr class="<?php echo $class; ?>">
                            <td><?php echo $this->safe->decrypt($FN); ?></td>
                            <td><?php echo $this->safe->decrypt($LN); ?></td>
                            <td><?php echo $this->safe->decrypt($Email); ?></td>
                            <td><?php echo $this->safe->decrypt($Phone); ?></td>
                            <td><a href="/Staff/Studentview/View/?ID=<?php echo $ID; ?>"><button class="Update">view</button></a></td>
                        </tr>
                    <?php
                    }
                      ?>
                        <tr><td><?php if(isset($_GET["Page"]) && $_GET["Page"] != 1){ ?><a href="/Staff/Studentview/?Page=<?php echo $pre ?>"><button><img alt="PRE" src="/static/images/angles-left-solid.svg"></button></a><?php } ?></td><td></td><td></td><td></td><td><?php if( $stmt->num_rows == 15){ ?><a href="/Staff/Studentview/?Page=<?php echo $next ?>"><button><img alt="Next" src="/static/images/angles-right-solid.svg"></button></a><?php } ?></td></tr>
                        <?php 
                    $stmt->close();
                    
                }
            }
        }
        function ViewStudentsAssigned(){
            global $con;
            $offset = 0;$next = 2; $pre = 1;
            if(isset($_GET["Page"])){
                $offset = ($_GET["Page"] * 10) - 10;
                if(($_GET['Page']) != 1){
                    $pre = $_GET['Page'] - 1;
                }else{
                    $pre = $_GET['Page'];
                }
                $next = $_GET['Page'] + 1;
            }
            $ID = "";$Email = "";$FN = "";$LN = "";$active = "";
            if ($stmt = $con->prepare('SELECT m_account.UserID, m_account.Email, m_account.FirstName, m_account.LastName, m_account.Phone, m_login.Activated FROM m_account INNER JOIN m_login ON m_login.UserID = m_account.UserID INNER JOIN m_staff_assign ON m_staff_assign.SUserID = m_account.UserID WHERE m_account.AccountTypeID = "1M68hk3CBfFx0deu" AND m_staff_assign.MUserID = ? LIMIT 15 OFFSET ?')) {
                $stmt->bind_param("ss",$_SESSION["ID"],$offset);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($ID,$Email,$FN,$LN,$Phone,$active);
                    while($row = $stmt->fetch()){
                        if($active){
                            $class = "Active";
                        }else{
                            $class = "NonActive";
                        }
                        ?><tr class="<?php echo $class; ?>">
                            <td><?php echo $this->safe->decrypt($FN); ?></td>
                            <td><?php echo $this->safe->decrypt($LN); ?></td>
                            <td><?php echo $this->safe->decrypt($Email); ?></td>
                            <td><?php echo $this->safe->decrypt($Phone); ?></td>
                            <td><a href="/Staff/Notes/View/?ID=<?php echo $ID; ?>"><button class="Update">view Notes</button></a></td>
                        </tr>
                    <?php
                    }
                      ?>
                        <tr><td><?php if(isset($_GET["Page"]) && $_GET["Page"] != 1){ ?><a href="/Staff/Notes/?Page=<?php echo $pre ?>"><button><img alt="PRE" src="/static/images/angles-left-solid.svg"></button></a><?php } ?></td><td></td><td></td><td></td><td><?php if( $stmt->num_rows == 15){ ?><a href="/Staff/Notes/?Page=<?php echo $next ?>"><button><img alt="Next" src="/static/images/angles-right-solid.svg"></button></a><?php } ?></td></tr>
                        <?php 
                    $stmt->close();
                    
                }
            }
        }
    }