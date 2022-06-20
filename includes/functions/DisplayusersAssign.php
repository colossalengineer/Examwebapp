<?php
    /* 
        Author: TJ Navarro-barber
        File Name: DisplayusersAssign.php
        Function: Displays table of users
    */
    class DisplayUsersAssign{
        public function __construct() {
            global $perms;
            global $data;
            global $audit;
            $this->safe = $data;
            $this->perm = $perms;
            $this->audit = $audit;
        }
        public function DisplayUsers($type){
            if($type == "Student"){
                $this->DisplayStudents();
            }else{
                $this->DisplayParents();
            }
        }
        private function DisplayStudents(){
            global $con;
            $ID = "";$Email = "";$FN = "";$LN = "";$active = "";
            if ($stmt = $con->prepare('SELECT MUserID, SUserID FROM m_staff_assign WHERE 1')) {
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($MID,$SID);
                    while($row = $stmt->fetch()){
                        if ($stmt2 = $con->prepare('SELECT m_account.FirstName, m_account.LastName, m_staff_titles.Name FROM m_account INNER JOIN m_staff_titles_assign ON m_account.UserID = m_staff_titles_assign.UserID INNER JOIN m_staff_titles ON m_staff_titles.TitleID = m_staff_titles_assign.TitleID WHERE m_account.UserID =?')) {
                            $stmt2->bind_param("s",$MID);
                            $stmt2->execute();
                            $stmt2->store_result();
                            if ($stmt2->num_rows > 0) {
                                $stmt2->bind_result($MFN,$MLN,$MTitle);
                                $stmt2->fetch();
                                $stmt2->close();
                            }
                        }
                        if ($stmt2 = $con->prepare('SELECT FirstName, LastName FROM m_account WHERE UserID = ?')) {
                            $stmt2->bind_param("s",$SID);
                            $stmt2->execute();
                            $stmt2->store_result();
                            if ($stmt2->num_rows > 0) {
                                $stmt2->bind_result($SFN,$SLN);
                                $stmt2->fetch();
                                $stmt2->close();
                            }
                        }
                        $class = "Active";
                        ?><tr class="<?php echo $class; ?>">
                            <td><?php echo $this->safe->decrypt($MFN); ?></td>
                            <td><?php echo $this->safe->decrypt($MLN); ?></td>
                            <td><?php echo $MTitle; ?></td>
                            <td><?php echo $this->safe->decrypt($SFN); ?></td>
                            <td><?php echo $this->safe->decrypt($SLN); ?></td>
                            <td><a href="/managment/ManageTutors/Assign/UnAsign/?MID=<?php echo $MID; ?>&SID=<?php echo $SID; ?>"><button class="Delete">Delete</button></a></td>
                        </tr>
                    <?php
                    }
                    $stmt->close();
                }
            }
        }
        private function DisplayParents(){
            global $con;
            $ID = "";$Email = "";$FN = "";$LN = "";$active = "";
            if ($stmt = $con->prepare('SELECT SUserID, PUserID FROM m_parent_assign WHERE 1')) {
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($MID,$SID);
                    while($row = $stmt->fetch()){
                        if ($stmt2 = $con->prepare('SELECT m_account.FirstName, m_account.LastName FROM m_account WHERE m_account.UserID =?')) {
                            $stmt2->bind_param("s",$MID);
                            $stmt2->execute();
                            $stmt2->store_result();
                            if ($stmt2->num_rows > 0) {
                                $stmt2->bind_result($MFN,$MLN);
                                $stmt2->fetch();
                                $stmt2->close();
                            }
                        }
                        if ($stmt2 = $con->prepare('SELECT FirstName, LastName FROM m_account WHERE UserID = ?')) {
                            $stmt2->bind_param("s",$SID);
                            $stmt2->execute();
                            $stmt2->store_result();
                            if ($stmt2->num_rows > 0) {
                                $stmt2->bind_result($SFN,$SLN);
                                $stmt2->fetch();
                                $stmt2->close();
                            }
                        }
                        $class = "Active";
                        ?><tr class="<?php echo $class; ?>">
                            <td><?php echo $this->safe->decrypt($MFN); ?></td>
                            <td><?php echo $this->safe->decrypt($MLN); ?></td>
                            <td><?php echo $this->safe->decrypt($SFN); ?></td>
                            <td><?php echo $this->safe->decrypt($SLN); ?></td>
                            <td><a href="/managment/ManageParent/Assign/UnAsign/?MID=<?php echo $MID; ?>&SID=<?php echo $SID; ?>"><button class="Delete">Delete</button></a></td>
                        </tr>
                    <?php
                    }
                    $stmt->close();
                }
            }
        }
    }