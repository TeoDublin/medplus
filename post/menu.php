<?php 
    require '../includes.php';
    Users()->update(params: ['set'=>['u_user'=>$_POST['user'],'u_pasword'=>$_POST['password'],'u_template'=>$_POST['template']],'u_id'=>Session()->get('user_id')]);
    $user=users()->first(['u_id'=>Session()->get('user_id')]);
    Session()->start($user);
    redirect($_SERVER['HTTP_REFERER']);