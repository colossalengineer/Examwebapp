<?php
    /* 
        Author: TJ Navarro-barber
        File Name: listusers.php
        Function: Creates a list of users
    */
    class ListUsers{
        public function __construct() {
            global $perms;
            global $data;
            global $audit;
            $this->safe = $data;
            $this->perm = $perms;
            $this->audit = $audit;
        }
        public function ListUsers($type){
            if($type == "Staff"){
                $this->ListStaff();
            }elseif($type == "Tutors"){
                $this->ListTutors();
            }elseif($type == "Student"){
                $this->ListStudents();
            }else{
                $this->ListParents();
            }
        }
        private function ListStaff(){

        }
        private function ListTutors(){
            global $con;
            if ($stmt = $con->prepare('SELECT m_account.UserID, m_account.FirstName, m_account.LastName FROM m_account INNER JOIN m_staff_titles_assign ON m_staff_titles_assign.UserID = m_account.UserID INNER JOIN m_staff_titles ON m_staff_titles_assign.TitleID = m_staff_titles.TitleID WHERE m_account.AccountTypeID = "TeuZ9FYleJIo4ZKG"')) {
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($ID,$FN,$LN);
                    while($row = $stmt->fetch()){
                        if((!$this->perm->UserHasPermByPermName($ID,"Root") && ($this->perm->UserHasPermByPermNameFromArray($ID,array("Tutor","TutorP","S.Tutor","H.Tutor")) )) ){    
                    ?>
                        <option value="<?php echo $ID ?>"><?php echo $this->safe->decrypt($FN) ?> <?php echo $this->safe->decrypt($LN) ?></option>
                    <?php }}
                }
            }
        }
        private function ListStudents(){
            global $con;
            if ($stmt = $con->prepare('SELECT m_account.UserID, m_account.FirstName, m_account.LastName FROM m_account INNER JOIN m_login ON m_login.UserID = m_account.UserID WHERE m_account.AccountTypeID = "1M68hk3CBfFx0deu"')) {
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($ID,$FN,$LN);
                    while($row = $stmt->fetch()){?>
                        <option value="<?php echo $ID ?>"><?php echo $this->safe->decrypt($FN) ?> <?php echo $this->safe->decrypt($LN) ?></option>
                    <?php }
                }
            }
        }
        private function ListParents(){
            global $con;
            if ($stmt = $con->prepare('SELECT m_account.UserID, m_account.FirstName, m_account.LastName FROM m_account INNER JOIN m_login ON m_login.UserID = m_account.UserID WHERE m_account.AccountTypeID = "g9VGZTnkZuXjk6qs"')) {
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($ID,$FN,$LN);
                    while($row = $stmt->fetch()){?>
                        <option value="<?php echo $ID ?>"><?php echo $this->safe->decrypt($FN) ?> <?php echo $this->safe->decrypt($LN) ?></option>
                    <?php }
                }
            }
        }
    }