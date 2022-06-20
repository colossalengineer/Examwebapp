<?php 
    /* 
        Author: TJ Navarro-barber
        File Name: studentdash.php
        Function: student dashboard 
    */
    class Studentdash{
        private $dash = 0;
        // Constructor
        public function __construct() {
            global $perms;
            global $data;
            global $audit;
            $this->safe = $data;
            $this->perm = $perms;
            $this->audit = $audit;
        }
        // Displays all of the students subjects
        private function GetStudentSubjects(){
            global $con;
            if ($stmt = $con->prepare('SELECT m_subject.SubjectclassID, m_subject.Name, m_subject_id.Colour FROM m_subject_assign INNER JOIN m_subject on m_subject_assign.SubjectclassID = m_subject.SubjectclassID INNER JOIN m_subject_id ON m_subject.SubjectID = m_subject_id.SubjectID WHERE m_subject_assign.UserID = ? ')) {
                $stmt->bind_param('s', $_SESSION["ID"]);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($ID,$Role,$Colour);
                    
                    while($row = $stmt->fetch()){

                        if ($stmt2 = $con->prepare('SELECT Score, NoQ FROM m_student_subject_score WHERE UserID = ? AND SubjectID = ?')) {
                            $stmt2->bind_param('ss', $_SESSION["ID"],$ID);
                            $stmt2->execute();
                            $stmt2->store_result();
                            if ($stmt2->num_rows > 0) {
                                $stmt2->bind_result($Score,$NoQ);
                                $stmt2->fetch();
                                $stmt2->close();
                                if($NoQ != 0 && $Score != 0){
                                    $avg = $Score / $NoQ;
                                }else{
                                    $avg = 0;
                                }
                            }else{
                                $stmt2->close();
                                if ($stmt2 = $con->prepare('INSERT INTO m_student_subject_score (UserID,SubjectID) VALUES (?,?)')) {
                                    $stmt2->bind_param('ss', $_SESSION["ID"],$ID);
                                    $stmt2->execute();
                                    $stmt2->close();
                                    $avg = 0;
                                }
                            }?>
                        <div class="item"><a href="/Students/SubjectContent/?ID=<?php echo $ID ?>"><button <?php if($Colour){?>style="background-color: #<?php echo $Colour; ?>;"<?php }?>><h4><?php echo $Role; ?></h4><progress value="<?php echo $avg; ?>" max="100"><?php echo $avg; ?>%</progress><span><?php echo $avg; ?>%</span></button></a></div>
                    <?php }
                    }
                }else{
                    
                }
            }
        }
        // Displays the students score
        private function GetStudentsscore(){
            global $con;
            $Total = 0;
            if ($stmt = $con->prepare('SELECT Score, NoQ FROM m_student_subject_score WHERE UserID = ?')) {
                $stmt->bind_param('s', $_SESSION["ID"]);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($Score,$NoQ);
                    $aavg= 0;
                    $count = 0;
                    while($row =$stmt->fetch()){
                        $avg = 0;
                        if($Score != 0 && $NoQ != 0){
                            $avg = $Score / $NoQ;
                        }
                        $aavg = $aavg + $avg;
                        $count++;
                    }
                    if($aavg != 0 ){
                        $Total = $aavg / $count++;
                    }
                    $stmt->close();
                    $Total = round($Total,  2, PHP_ROUND_HALF_UP);
                }?>
                    <div>
                        <h3>Average Score:</h3>
                        <progress value="<?php echo $Total; ?>" max="100"><?php echo $Total; ?>%</progress>
                        <p><?php echo $Total; ?>%</p>
                    </div>
            <?php }
        }
        // Displays Students Assignments
        private function DiplayAssignments(){
            global $con;
            if ($stmt = $con->prepare('SELECT m_form.Title, m_form.Noquestions, m_form_assign.Complete, m_form.Active, m_form_type.Name, m_subject.Name, m_form.ClosingDate FROM m_form_assign INNER JOIN m_form ON m_form.FormID = m_form_assign.FormID INNER JOIN m_form_type ON m_form_type.TypeID = m_form.Formtype INNER JOIN m_subject ON m_subject.SubjectclassID = m_form.SubjectclassID INNER JOIN m_subject_assign ON m_form.SubjectclassID = m_subject_assign.SubjectclassID AND m_subject_assign.UserID = m_form_assign.UserID WHERE m_form_assign.UserID = ?')) {
                $stmt->bind_param('s', $_SESSION["ID"]);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($Title,$noQ,$Complete,$active,$Type,$Subject,$ClosingDate);
                    $count = 0;
                    while($row = $stmt->fetch()){
                        if(!$Complete && $active){$count++;
                        ?>
                        <tr><td><?php echo $Title ?></td><td><?php echo $Type ?></td><td><?php echo $noQ ?></td></tr>
                    <?php }}
                    if($count == 0){?>
                        <tr><td>No</td><td>Assinments</td><td>To</td><td>Do</td><th><button class="Update" onclick="location.reload()">Update</button></th></tr> 
                    <?php }
                    
                }else{?>
                    <tr id="head"><td>No</td><td>Assignments</td><td>To</td><td>Do</td><th><button class="Update" onclick="location.reload()">Update</button></th></tr> 
                <?php }
            }
        }
        // Displays Students Dashboard
        public function display(){?>
            <div id="subjects">
                <?php $this->GetStudentSubjects(); ?>
            </div>
            <div id="Sudent-mainconent">
                <div id="Sudent-conent">
                    <aside id="Score">
                        <?php $this->GetStudentsscore(); ?>
                    </aside>
                    <aside id="Assign">
                        <table>
                            <tr id="head"><td>Title</td><td>Type</td><td>Subject</td><td>Number Of Questions</td><th><button class="Update" onclick="location.reload()">Update</button></th></tr> 
                            <?php $this->DiplayAssignments(); ?>
                        </table>
                    </aside>
                </div>
                <div id="Rewards">
                    Rewards
                    <?php include "C:/xampp/htdocs/GibJohn/includes/Comming_soon.php"; ?>
                </div>
            </div>
        <?php }
    }