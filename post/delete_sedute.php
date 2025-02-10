<?php
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    $recalc_percorso=[];
    foreach(Select('*')->from('percorsi_terapeutici_sedute')->where("id IN(".implode(',',$_REQUEST['ids']).")")->get() as $seduta){
        $recalc_percorso[$seduta['id_percorso']]=true;
        Delete()->from('percorsi_terapeutici_sedute')->where("id={$seduta['id']}");
    }
    foreach($recalc_percorso as $id_percorso=>$v){
        $percorso=Select('*')->from('percorsi_terapeutici')->where("id={$id_percorso}")->first();
        $sedute=Select('*')->from('percorsi_terapeutici_sedute')->where("id_percorso={$id_percorso}")->get();
        $prezzo_a_seduta = (int)$percorso['prezzo']/(int)$percorso['sedute'];
        Update('percorsi_terapeutici')->set([
            'sedute'=>count($sedute),
            'prezzo'=>$prezzo_a_seduta*count($sedute)
        ])
        ->where("id={$id_percorso}");
    }