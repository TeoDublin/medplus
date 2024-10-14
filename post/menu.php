<?php 
    require '../includes.php';
    if($_POST['u_user'])$set['u_user']=$_POST['user'];
    if($_POST['u_pasword'])$set['u_pasword']=$_POST['password'];
    if($_POST['u_template'])$set['u_template']=$_POST['template'];
    Users()->update(params: ['set'=>$set,'u_id'=>Session()->get('user_id')]);
    $user=users()->first(['u_id'=>Session()->get('user_id')]);
    Session()->start($user);
    redirect($_SERVER['HTTP_REFERER']);