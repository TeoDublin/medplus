<?php 
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    header('Content-Type: application/json; charset=utf-8');

    $id_indirizzato_a = request('id_indirizzato_a');
    
    if(null_or_empty($id_indirizzato_a)){
        $ret = ['msg'=>'Seleziona qualcosa'];
    }
    else{
        $uscite_registrate = Select('*')->from('uscite_registrate')->where("id_indirizzato_a = {$id_indirizzato_a}")->first_or_false();

        if($uscite_registrate){
            $ret = ['msg'=>'Impossibile eliminare, Uscita già registrata'];
        }
        else{

            Delete()->from('uscite_indirizzato_a')->where("id = {$id_indirizzato_a}");
            $ret = array_merge($_REQUEST,['msg'=>'success']);
        }
    }

    echo json_encode($ret);