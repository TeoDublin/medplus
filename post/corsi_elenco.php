<?php
    $_REQUEST['skip_cookie']=true;
    require '../includes.php';
    $id=request('id');
    $corso=[
        'id_categoria'=>$_REQUEST['id_categoria'],
        'id_terapista'=>$_REQUEST['id_terapista'],
        'corso'=>$_REQUEST['corso'],
        'prezzo'=>$_REQUEST['prezzo'],
        'scadenza'=>$_REQUEST['scadenza']
    ];
    if($id&&!empty($id))Update('corsi')->set($corso)->where("id={$id}");
    else $id=Insert($corso)->into('corsi')->get();
    
    Delete($id)->from('corsi_giorni','id_corso');
    foreach ($_REQUEST['days'] as $day) {
        Insert(['id_corso'=>$id,'giorno'=>$day['giorno'],'inizio'=>$day['inizio'],'fine'=>$day['fine']])->into('corsi_giorni');
    }

    Delete($id)->from('corsi_classi','id_corso');
    foreach ($_REQUEST['clienti'] as $cliente) {
        Insert(['id_corso'=>$id,'id_cliente'=>$cliente['cliente'],'prezzo'=>$cliente['prezzo'],'data_inizio'=>$cliente['data_inizio']])->into('corsi_classi');
    }

