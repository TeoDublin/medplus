<?php
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    $id=request('id_utente');
    $table='utenti';
    if($id&&!empty($id)){
        Update($table)->set([
            'nome'=>$_REQUEST['nome'],
            'user'=>$_REQUEST['user'],
            'password'=>password_hash($_REQUEST['password'], PASSWORD_DEFAULT),
        ])->where("id={$id}");
    }