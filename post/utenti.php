<?php
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    $id=request('id_utente');
    $table='utenti';
    if($id&&!empty($id)){
        Update($table)->set(['nome'=>$_REQUEST['nome'],'user'=>$_REQUEST['user']])->where("id={$id}");
        Update('ruoli_utenti')->set(['id_ruolo'=>$_REQUEST['id_ruolo']])->where("id_utente={$id}");
    }
    else{
        $id=Insert([
            'nome'=>$_REQUEST['nome'],
            'user'=>$_REQUEST['user'],
            'password'=>password_hash('medplus', PASSWORD_DEFAULT),
        ])->into($table)->get();
        Insert([
            'id_utente'=>$id,
            'id_ruolo'=>$_REQUEST['id_ruolo']
        ])->into('ruoli_utenti');
        Insert([
            'id_utente'=>$id,
            'chiave'=>'planning_colors',
            'valore'=>Select('*')->from('setup')->where("`key`='planning_colors'")->first()['setup']
        ])->into('utenti_preferenze');
    }