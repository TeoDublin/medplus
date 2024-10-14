<?php 
    require '../includes.php';
    $set=[];
    if(!empty($_POST['user']))$set['u_user']=$_POST['user'];
    if(!empty($_POST['pasword']))$set['u_pasword']=$_POST['password'];
    if(!empty($_POST['template']))$set['u_template']=$_POST['template'];
    Users()->update(params: ['set'=>$set,'u_id'=>Session()->get('user_id')]);
    $user=users()->first(['u_id'=>Session()->get('user_id')]);
    Session()->start($user);
    redirect($_SERVER['HTTP_REFERER']);