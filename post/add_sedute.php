<?php
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    $percorso=Select('*')->from('percorsi_terapeutici')->where("id={$_REQUEST['id_percorso']}")->first();
    $sedute=Select('*')->from('percorsi_terapeutici_sedute')->where("id_percorso={$_REQUEST['id_percorso']}")->get();
    $prezzo_a_seduta = round((int)$percorso['prezzo']/(int)$percorso['sedute'],2);
    $index=Select('max(`index`) as max_index')->from('percorsi_terapeutici_sedute')->where("id_percorso={$_REQUEST['id_percorso']}")->first_or_false()['max_index'] ?? 0;
    $qtt=(int)$_REQUEST['qtt'];
    for($i=0;$i<$qtt;$i++){
        Insert([
            'index'=>++$index,
            'id_cliente'=>$_REQUEST['id_cliente'],
            'id_percorso'=>$_REQUEST['id_percorso'],
            'id_combo'=>$_REQUEST['id_combo'],
            'prezzo'=>$prezzo_a_seduta
        ])->into('percorsi_terapeutici_sedute');
    }
    Update('percorsi_terapeutici')->set([
        'sedute'=>count($sedute)+$qtt,
        'prezzo'=>$prezzo_a_seduta*(count($sedute)+$qtt)
    ])
    ->where("id={$_REQUEST['id_percorso']}");
    Sedute()->refresh($_REQUEST['id_percorso']);