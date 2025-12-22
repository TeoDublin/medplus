<?php 
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    header('Content-Type: application/json; charset=utf-8');

    $id_categoria = request('id_categoria');
    
    if(null_or_empty($id_categoria)){
        $ret = ['msg'=>'Seleziona qualcosa'];
    }
    else{
        $uscite_registrate = Select('*')->from('uscite_registrate')->where("id_categoria = {$id_categoria}")->first_or_false();

        if($uscite_registrate){
           $ret = ['msg'=>'Impossibile eliminare, Uscita già registrata'];
        }
        else{

            Delete()->from('uscite_categoria')->where("id = {$id_categoria}");
            $ret = array_merge($_REQUEST,['msg'=>'success']);
        }
    }

    echo json_encode($ret);