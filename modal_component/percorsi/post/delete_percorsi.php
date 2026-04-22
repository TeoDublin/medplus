<?php 

    $_REQUEST['skip_cookie']=true;

    require_once '../../../includes.php';
    
    header('Content-Type: application/json; charset=utf-8');

    $id = (int)$_REQUEST['id'];

    if(!$id){
        echo json_encode([
            'sucess'=>false,
            'message'=>'Percorso non trovato'
        ]);
        exit();
    }

    $pagamenti_child = Select('*')
        ->from('pagamenti_child')
        ->where("origine = 'Trattamenti'")
        ->and("id_origine = {$id}")
        ->first_or_false();

    if($pagamenti_child){
        echo json_encode([
            'success'=>false,
            'message'=>'Non puoi eliminare un percorso già  pagato'
        ]);
        exit();
    }

    Delete()->from('percorsi_terapeutici')->where("id={$id}");

    echo json_encode([
        'success'=>true
    ]);