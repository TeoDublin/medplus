<?php 
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    $user=Select('*')->from('utenti')->where("user='{$_REQUEST['user']}'")->first_or_false();
    if(!$user){
        echo 'not_found';
    }
    else{
        $token=bin2hex(random_bytes(6));
        Update('utenti')->set(['token'=>$token,'expiry'=>add_date('+1 hour')])->where("id={$user['id']}");
        $href=url("change_password.php?id={$user['id']}&token={$token}");
        $a=url("change_password.php");
        $sent=_Mail()->send($user['email'],'Cambia Password',"clica sul link per cambiare la password: <a href='{$href}'>{$a}</a>");
        echo $sent?'mail_sent':'error_sending';
    }