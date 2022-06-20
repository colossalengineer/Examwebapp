<?php
    /* 
        Author: TJ Navarro-barber
        File Name: audit.php
        Function: Display and Add items to Audit log
    */
    class audit{
        public function __construct() {
            global $data;
            global $perms;
            $this->safe = $data;
            $this->perm = $perms;
        }
        public function Addaudit($AuditType,$ChangeType,$ReleventID,$Content){
            global $con;
            if ($stmt = $con->prepare("INSERT INTO m_audit_log(UserID, AuditType, ChangeID, ReleventID, Content) VALUES (?,?,?,?,?)")){
                $content = $this->safe->encrypt($Content);
                $stmt->bind_param('sssss', $_SESSION["ID"],$AuditType,$ChangeType,$ReleventID,$content);
                $stmt->execute();
                $stmt->close();
            }
        }
        public function DisplayAuditLog($filterbytype = false,$filterbyevent = false){
            global $con;
            $FN= "";
            $LN= "";
            $AT= "";
            $AC= "";
            $RID= "";
            $Content= "";
            $time = "";
            $search = "";
            if($filterbytype  || $filterbyevent){
                if($filterbytype){
                    $search .= "m_audit_type.Name = 'Staff'";
                }
                if($filterbyevent){
                    if($search == ""){
                        $search .= "m_audit_change_type.Name = 'AddRole'";
                    }else{
                        $search .= "AND m_audit_change_type.Name = 'AddRole'";
                    }
                }
            }else{
                $search = 1;
            }
            $offset = 0;
            $next = 2; $pre = 1;
            if(isset($_GET["Page"])){
                $offset = ($_GET["Page"] * 10) - 10;
                if(($_GET['Page']) != 1){
                    $pre = $_GET['Page'] - 1;
                }else{
                    $pre = $_GET['Page'];
                }
                $next = $_GET['Page'] + 1;
            }
            if ($stmt = $con->prepare("SELECT m_account.FirstName, m_account.LastName, m_audit_type.Name, m_audit_change_type.Name, m_audit_log.ReleventID, m_audit_log.Content, m_audit_log.Time FROM m_audit_log INNER JOIN m_audit_type ON m_audit_log.AuditType = m_audit_type.TypeID INNER JOIN m_audit_change_type ON m_audit_log.ChangeID = m_audit_change_type.TypeID INNER JOIN m_account ON m_account.UserID = m_audit_log.UserID WHERE ? ORDER BY m_audit_log.Time DESC LIMIT 15 OFFSET ?")){
                $stmt->bind_param('ss', $search,$offset);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($FN,$LN,$AT,$AC,$RID,$Content,$time);
                    while($row =$stmt->fetch()){    
                    ?>
                        <tr>
                            <td>
                                <?php echo $this->safe->decrypt($FN); ?>
                            </td>
                            <td>
                                <?php echo $this->safe->decrypt($LN); ?>
                            </td>
                            <td>
                                <?php echo $AT; ?>
                            </td>
                            <td>
                                <?php echo $AC; ?>
                            </td>
                            <td>
                                <?php echo $this->perm->infofromID($RID); ?>
                            </td>
                            <td>
                                <?php echo $this->safe->decrypt($Content); ?>
                            </td>
                            <td>
                                <?php echo $time; ?>
                            </td>
                        </tr>
                    <?php }
                }else{
                    $header = 'Location: /Managment/audit/?Page='. $pre;
                    header($header, true, 301);
                }
            }
            ?>
                <tr><td><?php if(isset($_GET["Page"]) && $_GET["Page"] != 1){ ?><a href="/managment/Audit/?Page=<?php echo $pre ?>"><button><img alt="PRE" src="/static/images/angles-left-solid.svg"></button></a><?php }?></td><td></td><td></td><td></td><td></td><td></td><td><?php if($stmt->num_rows == 15){ ?><a href="/managment/Audit/?Page=<?php echo $next ?>"><button><img alt="Next" src="/static/images/angles-right-solid.svg"></button></a><?php }?></td></tr>
        <?php }
    }
    