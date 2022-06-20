<!-- Displaying UserName -->
<?php $temp = new perms(); 
    if(!isset($page)){
?>
<div id="user">
    <h3><?php echo $temp->GetNameOfUser(); ?></h3>
</div>
<?php } ?>
<!-- App -->