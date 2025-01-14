<?php
    $_REQUEST['skip_cookie']=true;
    require '../includes.php';
    $percorso=Select('*')->from('percorsi_terapeutici')->where("id={$_REQUEST['id_percorso']}")->first();
    $id_deduta=Insert([
        'index'=>0,
        'id_cliente'=>$percorso['id_cliente'],
        'id_percorso'=>$percorso['id'],
        'id_trattamento'=>$percorso['id_trattamento']
    ])->into('percorsi_terapeutici_sedute')->get();
    Insert([
        'row_inizio'=>$_REQUEST['row_inizio'],
        'row_fine'=>$_REQUEST['row_fine'],
        'id_terapista'=>$_REQUEST['id_terapista'],
        'id_seduta'=>$id_deduta,
        'id_percorso'=>$percorso['id'],
        'data'=>$_REQUEST['data'],
        'id_cliente'=>$percorso['id_cliente']
    ])->into('percorsi_terapeutici_sedute_prenotate')->get();
    