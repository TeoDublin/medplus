<?php
    $_REQUEST['skip_cookie']=true;
    require '../includes.php';
    if($_REQUEST['id_percorso']){
        Update('percorsi_terapeutici')
        ->set(['prezzo'=>$_REQUEST['prezzo'],'note'=>$_REQUEST['note']])
        ->where("id={$_REQUEST['id_percorso']}");
    }