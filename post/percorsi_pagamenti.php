<?php
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    $id=request('id_percorso');
    unset($_REQUEST['table']);
    Update('percorsi_terapeutici')->set($_REQUEST)->where("id={$id}");