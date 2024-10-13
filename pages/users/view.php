<?php 
    require root('menu-header.php');
    $users=Users()->select(['select'=>['u_id','u_user','u_email'],'limit'=>10, 'offset'=>0]);
    
    html()->table(['thead'=>['Utente', 'Email di ricupero'],'tbody'=>$users, 'class'=>['m-4']]);
?>

<?php require root('menu-footer.php');?>