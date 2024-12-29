<?php
    $_REQUEST['skip_cookie']=true;
    require '../includes.php';
    $id=request('id');
    $table=request('table');
    $data_inizio=request('data_inizio');
    $scadenza=request('scadenza');
    if($id&&!empty($id))Update($table)->set($_REQUEST)->where("id={$id}");
    else $id=Insert($_REQUEST)->into($table)->get();

    if($_REQUEST['tipo_percorso']=='Mensile'){
        $_data=[
            'id_cliente'=>$_REQUEST['id_cliente'],
            'id_percorso'=>$id,
            'data_inizio'=>$data_inizio,
            'scadenza'=>$scadenza
        ];
        if(($percorsi_mensili=Select('*')->from('percorsi_mensili')->where("id_percorso={$id}")->get_or_false())){
            Update('percorsi_mensili')->set($_data)->where("id={$percorsi_mensili['id']}");
        }
        else Insert($_data)->into('percorsi_mensili');
    }