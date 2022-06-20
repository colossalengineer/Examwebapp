<?php
    /* 
        Author: TJ Navarro-barber
        File Name: DisplayFormQuestions.php
        Function: Display Form Questions / Question Info
    */
    class DisplayFormQuestions{
        public function __construct() {
            global $perms;
            global $data;
            global $audit;
            $this->safe = $data;
            $this->perm = $perms;
            $this->audit = $audit;
        }
        public function DisplayQuestionInfo($ID){
            global $con;
            if($stmt = $con->prepare("SELECT m_form_question.Pos, m_form_question.NoA, m_form_question_type.Name, m_form_question.Question, m_form_question.Points FROM m_form_question INNER JOIN m_form_question_type ON m_form_question.QuestionType = m_form_question_type.TypeID WHERE m_form_question.QuestionID = ?")){
                $stmt->bind_param("s",$ID);
                $stmt->execute();
                $stmt->store_result();
                if($stmt->num_rows > 0){
                    $stmt->bind_result($Pos,$NoA,$Type,$Question,$Points);
                    $stmt->fetch();
                }
                if($Question != ""){
                    $Question = $this->safe->decrypt($Question);
                }
            }?>
            <div class="Question">
                <h3>Question <?php echo $Pos ?></h3>
                <div>Question: <?php echo $Question ?></div>
                <div>Type: <?php echo $Type ?></div>
                <div>Position: <?php echo $Pos ?></div>
                <div>Number of Answers: <?php echo $NoA ?></div>
                <div>points: <?php echo $Points ?></div>
                <div><a href="/Staff/Forms/Create/EditForm/EditQuestion/?ID=<?php echo $ID ?>"><button class="Update">Edit Question</button></a></div>
                <div><a><button disabled class="Delete deactivated">Delete Question</button></a></div>
                <!-- href="/Staff/Forms/Create/EditForm/DeleteQuestion?ID=<?php //echo $ID ?>" -->
            </div>
        <?php }
        public function DisplayQuestion($ID){
            global $con;
            if($stmt = $con->prepare("SELECT m_form_question.Pos, m_form_question.NoA, m_form_question_type.Name, m_form_question.Question, m_form_question.Points FROM m_form_question INNER JOIN m_form_question_type ON m_form_question.QuestionType = m_form_question_type.TypeID WHERE m_form_question.QuestionID = ?")){
                $stmt->bind_param("s",$ID);
                $stmt->execute();
                $stmt->store_result();
                if($stmt->num_rows > 0){
                    $stmt->bind_result($Pos,$NoA,$Type,$Question,$Points);
                    $stmt->fetch();
                }
                if($Question != ""){
                    $Question = $this->safe->decrypt($Question);
                }
                if($Type == "Info"){
                    if($stmt = $con->prepare("SELECT AnswerID, Responce FROM m_form_question_answers WHERE QuestionID = ?")){
                        $stmt->bind_param("s",$ID);
                        $stmt->execute();
                        $stmt->store_result();
                        if($stmt->num_rows > 0){
                            $stmt->bind_result($AID,$Res);
                            $stmt->fetch();
                        }
                    }
                    ?>
                    <div class="Question">
                        <h3><?php echo $Question ?></h3>
                        <div><?php echo $Res ?></div>
                    </div>
                <?php }elseif($Type == ""){

                }
            }
        }
    }