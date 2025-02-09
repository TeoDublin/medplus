<?php
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    $id=request('id');
    $first_date=now('Y-m-d');
    $corso=[
        'id_categoria'=>$_REQUEST['id_categoria'],
        'id_terapista'=>$_REQUEST['id_terapista'],
        'corso'=>$_REQUEST['corso'],
        'prezzo'=>$_REQUEST['prezzo'],
        'scadenza'=>$_REQUEST['scadenza']
    ];
    if($id&&!empty($id))Update('corsi')->set($corso)->where("id={$id}");
    else $id=Insert($corso)->into('corsi')->get();
    
    Delete()->from('corsi_giorni')->where("id_corso={$id}");
    foreach ($_REQUEST['days'] as $day) {
        Insert(['id_corso'=>$id,'giorno'=>$day['giorno'],'inizio'=>$day['inizio'],'fine'=>$day['fine']])->into('corsi_giorni');
    }

    Delete()->from('corsi_classi')->where("id_corso={$id}");
    foreach ($_REQUEST['clienti'] as $cliente) {
        if($cliente['data_inizio']<$first_date)$first_date=$cliente['data_inizio'];
        Insert(['id_corso'=>$id,'id_cliente'=>$cliente['cliente'],'prezzo'=>$cliente['prezzo'],'data_inizio'=>$cliente['data_inizio']])->into('corsi_classi');
    }
    $_REQUEST['id_corso']=$id;
    $_REQUEST['data_inizio']=$first_date;
    require_once __DIR__.'/../jobs/corsi_planning.php';