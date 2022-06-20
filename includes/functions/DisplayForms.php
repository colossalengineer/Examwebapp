<?php
    /* 
        Author: TJ Navarro-barber
        File Name: DisplayForms.php
        Function: Displays all forms for the user
    */
    class DisplayForms{
        public function __construct() {
            global $perms;
            global $data;
            global $audit;
            $this->safe = $data;
            $this->perm = $perms;
            $this->audit = $audit;
        }
        public function DisplayAllForms(){
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
            if ($stmt = $con->prepare('SELECT m_form.FormID, m_form.Title, m_form.Active, m_form.AssignOnly, m_form_type.Name, m_subject.Name FROM m_form INNER JOIN m_form_type ON m_form_type.TypeID = m_form.Formtype INNER JOIN m_subject ON m_subject.SubjectclassID = m_form.SubjectclassID WHERE 1 LIMIT 15 OFFSET ?')) {
                $stmt->bind_param("s",$offset);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($ID,$Title,$active,$Assign,$Type,$Subject);
                    while($row = $stmt->fetch()){
                        if($active){
                            $class = "Active";
                        }else{
                            $class = "NonActive";
                        }
                        ?><tr class="<?php echo $class; ?>">
                            <td><?php echo $this->safe->decrypt($Title); ?></td>
                            <td><?php echo $Type; ?></td>
                            <td><?php echo $Subject; ?></td>
                            <td><?php echo $Assign; ?></td>
                            <td><a href="/Staff/Forms/Create/EditForm/?ID=<?php echo $ID; ?>"><button class="Update">Edit</button></a></td>
                            <td><a href="/Staff/Forms/Create/DeleteUser/?ID=<?php echo $ID; ?>"><button class="Delete">Delete</button></a></td>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr><td><?php if(isset($_GET["Page"]) && $_GET["Page"] != 1){ ?><a href="/managment/ManageStaff/?Page=<?php echo $pre; ?>"><button><img alt="PRE" src="/static/images/angles-left-solid.svg"></button></a><?php } ?></td><td></td><td></td><td></td><td></td><td><?php if($stmt->num_rows == 15){ ?><a href="/managment/ManageStaff/?Page=<?php echo $next ?>"><button><img alt="Next" src="/static/images/angles-right-solid.svg"></button></a><?php } ?></td></tr>
                    <?php 
                    $stmt->close();
                }
            }
        }
        public function DisplayResouses($SID){
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
            if ($stmt = $con->prepare('SELECT m_form.FormID, m_form.Title, m_form_type.Name FROM m_form INNER JOIN m_form_type ON m_form_type.TypeID = m_form.Formtype INNER JOIN m_subject ON m_subject.SubjectclassID = m_form.SubjectclassID WHERE m_form.SubjectclassID = ? AND m_form.Active = 1 AND m_form.AssignOnly = 0 LIMIT 15 OFFSET ?')) {
                $stmt->bind_param("ss",$SID,$offset);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($ID,$Title,$Type);
                    while($row = $stmt->fetch()){
                        ?><tr class="">
                            <td><?php echo $this->safe->decrypt($Title); ?></td>
                            <td><?php echo $Type; ?></td>
                            <td><a href="/Students/SubjectContent/Form/?FID=<?php echo $ID; ?>&SID=<?php echo $SID; ?>"><button class="Update">View</button></a></td>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr><td><?php if(isset($_GET["Page"]) && $_GET["Page"] != 1){ ?><a href="/managment/ManageStaff/?ID<?php echo $ID; ?>&Page=<?php echo $pre; ?>"><button><img alt="PRE" src="/static/images/angles-left-solid.svg"></button></a><?php } ?></td><td></td><td><?php if($stmt->num_rows == 15){ ?><a href="/managment/ManageStaff/?ID<?php echo $ID; ?>&Page=<?php echo $next ?>"><button><img alt="Next" src="/static/images/angles-right-solid.svg"></button></a><?php } ?></td></tr>
                    <?php 
                    $stmt->close();
                }
            }
        }
        public function DisplayForm($ID){
            global $con;
            $quest = new DisplayFormQuestions();
            if($stmt = $con->prepare("SELECT m_form_type.Name, m_form.Title FROM m_form INNER JOIN m_form_type ON m_form_type.TypeID = m_form.Formtype WHERE m_form.FormID = ?")){
                $stmt->bind_param("s",$ID);
                $stmt->execute();
                $stmt->store_result();
                if($stmt->num_rows > 0){
                    $stmt->bind_result($Type,$Title);
                    $stmt->fetch();
                }?>
                <h2><?php echo $this->safe->decrypt($Title); ?></h2>
            <?php }
            if($Type == "Resource"){
                if($stmt = $con->prepare("SELECT QuestionID FROM m_form_question WHERE FormID = ? ORDER BY Pos ASC")){
                    $stmt->bind_param("s",$ID);
                    $stmt->execute();
                    $stmt->store_result();
                    if($stmt->num_rows > 0){
                        $stmt->bind_result($QuestionID);
                        while($row = $stmt->fetch()){
                            $quest->DisplayQuestion($QuestionID);
                        }
                    }
                }
            }
        }
    }