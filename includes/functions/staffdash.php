<?php
    /* 
        Author: TJ Navarro-barber
        File Name: staffdah.php
        Function: staff dashboard
    */
    class Staffdash{
        private $dash = 0;
        public function __construct() {
            global $perms;
            global $data;
            global $audit;
            $this->safe = $data;
            $this->perm = $perms;
            $this->audit = $audit;
        }
        private function Additem($name,$redirect,$image,$bgcolour){ ?>
            <a title="<?php echo $name; ?>" href="<?php echo $redirect; ?>">
                <button title="<?php echo $name; ?>" class="<?php echo $bgcolour; ?>">
                    <img alt="<?php echo $name; ?>" src="<?php echo $image; ?>">
                    <div class="text">
                        <?php echo $name; ?>
                    </div>
                </button>
            </a>
        <?php }
        public function Display(){
            ?> <div id="staffdash"> <?php
            if($this->perm->HasPermByPermNameFromArray(array("root","S.Management","H.Management"))){
                $this->Additem("Manage Staff","/managment/ManageStaff/","/static/images/pencil-solid.svg","l1");
            }
            if($this->perm->HasPermByPermName("Dev")){
                $this->Additem("Dev","/DevTools/","/static/images/code-solid.svg","l1");
            }
            if($this->perm->HasPermByPermName("Dev")){
                $this->Additem("TODO","/DevTools/TODO","/static/images/list-ul-solid.svg","l1");
            }
            if($this->perm->HasPermByPermNameFromArray(array("root","Audit"))){
                $this->Additem("audit","/managment/audit/","/static/images/eye-solid.svg","l1");
            }
            if($this->perm->HasPermByPermNameFromArray(array("H.Tutor","S.Tutor","M.Management"))){
                $this->Additem("Manage Tutors","/managment/ManageTutors/","/static/images/user-pen-solid.svg","l2");
            }
            if($this->perm->HasPermByPermNameFromArray(array("H.Tutor","S.Tutor"))){
                $this->Additem("Assign Tutors","/managment/ManageTutors/Assign/","/static/images/user-group-solid.svg","l2");
            }
            if($this->perm->HasPermByPermNameFromArray(array("H.Tutor","PTutor"))){
                $this->Additem("Manage Parents","/managment/ManageParents/","/static/images/user-pen-solid.svg","l3");
            }
            if($this->perm->HasPermByPermNameFromArray(array("H.Tutor","PTutor"))){
                $this->Additem("Assign Parents","/managment/Manageparents/Assign/","/static/images/user-group-solid.svg","l3");
            }
            if($this->perm->HasPermByPermNameFromArray(array("H.Tutor","S.Tutor","TutorP"))){
                $this->Additem("Manage Students","/managment/ManageStudents/","/static/images/user-pen-solid.svg","l4");
            }
            if($this->perm->HasPermByPermNameFromArray(array("H.Tutor","Tutor"))){
                $this->Additem("Student View","/Staff/Studentview","/static/images/user-graduate-solid.svg","l4");
            }
            if($this->perm->HasPermByPermNameFromArray(array("H.Tutor","Tutor"))){
                $this->Additem("Student Notes","/Staff/Notes","/static/images/file-contract-solid.svg","l4");
            }
            if($this->perm->HasPermByPermNameFromArray(array("H.Tutor","S.Tutor","TutorP","Tutor"))){
                $this->Additem("Resources","/Staff/Forms","/static/images/file-lines-solid.svg","l4");
            }
            if($this->perm->HasPermByPermNameFromArray(array("H.Tutor","S.Tutor","TutorP","Tutor"))){
                $this->Additem("Rewards","/Staff/Rewards/","/static/images/trophy-solid.svg","l4");
            }
            if($this->perm->HasPermByPermNameFromArray(array("H.Tutor","S.Tutor","L.Tutor"))){
                $this->Additem("Leader Boards","/Staff/LeaderBoard/","/static/images/align-justify-solid.svg","l4");
            }
            ?> </div> <?php
        }
    }