<?php 
    require root('menu-header.php');
    $users=Users()->select_for_table(['select'=>['u_id','u_user','u_email']]);
    html()->table(['Utente', 'Email di ricupero'],$users);
?>

<?php require root('menu-footer.php');?>