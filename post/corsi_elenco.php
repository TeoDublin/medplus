<?php
    $_REQUEST['skip_cookie']=true;
    require '../includes.php';
    $id=request('id');
    $corso=[
        'id_categoria'=>$_REQUEST['id_categoria'],
        'corso'=>$_REQUEST['corso'],
        'prezzo'=>$_REQUEST['prezzo'],
        'scadenza'=>$_REQUEST['scadenza']
    ];
    if($id&&!empty($id))Update('corsi')->set($corso)->where("id={$id}");
    else $id=Insert($corso)->into('corsi')->get();
    
    Delete($id)->from('corsi_giorni','id_corso');
    foreach ($_REQUEST['days'] as $day) {
        Insert(['id_corso'=>$id,'giorno'=>$day['giorno'],'ora'=>$day['ora']])->into('corsi_giorni');
    }
