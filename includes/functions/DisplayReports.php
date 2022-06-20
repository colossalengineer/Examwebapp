<?php
    /* 
        Author: TJ Navarro-barber
        File Name: DisplayReports.php
        Function: Displays all report to staff users
    */
    class DisplayReports{
        public function __construct() {
            global $perms;
            global $data;
            global $Manage;
            $this->safe = $data;
            $this->perm = $perms;
            $this->Manage = $Manage;
        }
        public function DisplayReportsMain($ID){
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
            if ($stmt = $con->prepare('SELECT m_review.ReviewID , m_review.Title, m_review_type.Name, m_review.Date, m_review.Submit FROM m_review INNER JOIN m_review_type ON m_review_type.TypeID = m_review.ReviewType WHERE m_review.SUserID = ? AND m_review.MUserID = ? LIMIT 15 OFFSET ?')) {
                $stmt->bind_param("sss",$ID,$_SESSION["ID"],$offset);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($RID,$Title,$Type,$date,$active);
                    while($row = $stmt->fetch()){
                        if($active){
                            $class = "Active";
                        }else{
                            $class = "NonActive";
                        }
                        ?><tr class="<?php echo $class; ?>">
                            <td><?php echo $Title; ?></td>
                            <td><?php echo $Type; ?></td>
                            <td><?php echo $date; ?></td>
                            <td><a href="/Staff/Notes/EditReport/?ID=<?php echo $RID; ?>&SID=<?php echo $_GET["ID"]; ?>"><button class="Update">view</button></a></td>
                        </tr>
                    <?php
                    }
                        ?>
                        <tr><td><?php if(isset($_GET["Page"]) && $_GET["Page"] != 1){ ?><a href="/Staff/Notes/View/?ID=<?php echo $_GET["ID"] ?>&Page=<?php echo $pre ?>"><button><img alt="PRE" src="/static/images/angles-left-solid.svg"></button></a><?php } ?></td><td></td><td></td><td><?php if( $stmt->num_rows == 15){ ?><a href="/Staff/Notes/View/?ID=<?php echo $_GET["ID"] ?>&Page=<?php echo $next ?>"><button><img alt="Next" src="/static/images/angles-right-solid.svg"></button></a><?php } ?></td></tr>
                        <?php 
                    $stmt->close();
                    
                }
            }
        }
        public function DisplayReportsSecondary($ID){
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
            if ($stmt = $con->prepare('SELECT m_review.ReviewID , m_review.Title, m_review_type.Name, m_review.Date, m_review.Submit FROM m_review INNER JOIN m_review_type ON m_review_type.TypeID = m_review.ReviewType WHERE m_review.SUserID = ? AND m_review.Submit = 1 LIMIT 15 OFFSET ?')) {
                $stmt->bind_param("ss",$ID,$offset);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($RID,$Title,$Type,$date,$active);
                    while($row = $stmt->fetch()){
                        if($active){
                            $class = "Active";
                        }else{
                            $class = "NonActive";
                        }
                        ?><tr class="<?php echo $class; ?>">
                            <td><?php echo $Title; ?></td>
                            <td><?php echo $Type; ?></td>
                            <td><?php echo $date; ?></td>
                            <td><a href="/Staff/Notes/ViewReport/?ID=<?php echo $RID; ?>&SID=<?php echo $_GET["ID"]; ?>"><button class="Update">view</button></a></td>
                        </tr>
                    <?php
                    }
                        ?>
                        <tr><td><?php if(isset($_GET["Page"]) && $_GET["Page"] != 1){ ?><a href="/Staff/Notes/View/?ID=<?php echo $_GET["ID"] ?>&Page=<?php echo $pre ?>"><button><img alt="PRE" src="/static/images/angles-left-solid.svg"></button></a><?php } ?></td><td></td><td></td><td><?php if( $stmt->num_rows == 15){ ?><a href="/Staff/Notes/View/?ID=<?php echo $_GET["ID"] ?>&Page=<?php echo $next ?>"><button><img alt="Next" src="/static/images/angles-right-solid.svg"></button></a><?php } ?></td></tr>
                        <?php 
                    $stmt->close();
                    
                }
            }
        }
    }