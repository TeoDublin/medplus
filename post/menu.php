<?php 
    require '../includes.php';
    $set=[];
    if(!empty($_POST['user']))$set['user']=$_POST['user'];
    if(!empty($_POST['pasword']))$set['pasword']=$_POST['password'];
    if(!empty($_POST['template']))$set['template']=$_POST['template'];
    Users()->update(params: ['set'=>$set,'id'=>Session()->get('user_id')]);
    $user=users()->first(['id'=>Session()->get('user_id')]);
    Session()->start($user);
    redirect($_SERVER['HTTP_REFERER']);