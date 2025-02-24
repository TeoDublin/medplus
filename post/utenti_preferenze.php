<?php 
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    require_once '../includes/session.php';
    $session=Session();
    if(($user_id=$session->get('user_id'))){
        $data=":root{";
        foreach ($_REQUEST as $key => $value) $data.="{$key}:{$value};";
        $data.="}";

        Update('utenti_preferenze')->set(['chiave'=>'planning_colors','valore'=>$data])->where("id_utente={$user_id}");
    }