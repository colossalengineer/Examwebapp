<?php
    /* 
        Author: TJ Navarro-barber
        File Name: Devdash.php
        Function: Dev Dashboard
    */
    class Devdash{
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
                    <img src="<?php echo $image; ?>">
                    <div class="text">
                        <?php echo $name; ?>
                    </div>
                </button>
            </a>
        <?php }
        public function Display(){
            ?> <div id="staffdash"> <?php
                $this->Additem("addaudit","/DevTools/addaudit/","/static/images/code-solid.svg","l1");
                $this->Additem("Encrypt","/DevTools/Encrypt/","/static/images/code-solid.svg","l1");
                $this->Additem("ID","/DevTools/ID/","/static/images/code-solid.svg","l1");
                $this->Additem("Add Subject","/DevTools/AddSubject/","/static/images/code-solid.svg","l1");
                $this->Additem("TODO","/DevTools/TODO/","/static/images/code-solid.svg","l1");
            ?> </div> <?php
        }
    }
