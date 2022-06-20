<!-- Nav Bar -->
<?php
    // adds Item to Nav bar
    function AddNavItem($name,$redirect,$image){?>
        <a title="<?php echo $name; ?>" href="<?php echo $redirect; ?>"><button><img alt="<?php echo $name; ?>" src="<?php echo $image; ?>"><div><?php echo $name; ?></div></button></a>
    <?php }
?>
<nav>
    <a id="Dash" title="Dashboard" href="/Dashboard/"><button><img alt="Logout" src="/static/images/grip-solid.svg"><div>Dashboard</div></button></a>
    <?php
        if($_SESSION["logtype"] == "Staff"){
            if($perms->HasPermByPermName("Dev")){
                AddNavItem("Dev","/DevTools/","/static/images/code-solid.svg");
            }
            if($perms->HasPermByPermName("Dev")){
                AddNavItem("TODO","/DevTools/TODO","/static/images/list-ul-solid.svg");
            }
            if($perms->HasPermByPermNameFromArray(array("Root","S.Management"))){
                AddNavItem("Manage Staff","/managment/ManageStaff/","/static/images/pencil-solid.svg");
            }
            if($perms->HasPermByPermNameFromArray(array("Root","Audit"))){
                AddNavItem("audit","/managment/audit/","/static/images/eye-solid.svg");
            }
            if($perms->HasPermByPermNameFromArray(array("Tutor"))){
                AddNavItem("Student View","/Staff/Studentview","/static/images/user-graduate-solid.svg");
            }
            if($perms->HasPermByPermNameFromArray(array("Tutor"))){
                AddNavItem("Student Notes","/Staff/Notes","/static/images/file-contract-solid.svg");
            }
            if($perms->HasPermByPermNameFromArray(array("Tutor"))){
                AddNavItem("Resources","/Staff/Forms","/static/images/file-lines-solid.svg","l4");
            }
        }
    ?>
    <?php
        if($_SESSION["logtype"] == "Student"){
            if($perms->StudentHasPermByPermName($_SESSION["ID"],"Game")){
                AddNavItem("Games","/Students/Games/","/static/images/chess-board-solid.svg");
            }
        }
    ?>
    <a id="logout" title="Logout" href="/logout/"><button><img alt="Logout" src="/static/images/arrow-right-from-bracket-solid.svg"><div>Logout</div></button></a>
</nav>
<!-- Main Content -->