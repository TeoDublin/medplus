<?php 
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    header('Content-Type: application/json; charset=utf-8');

    $id_uscita = request('id_uscita');
    
    if(null_or_empty($id_uscita)){
        $ret = ['msg'=>'Seleziona qualcosa'];
    }
    else{
        $uscite_registrate = Select('*')->from('uscite_registrate')->where("id_uscita = {$id_uscita}")->first_or_false();

        if($uscite_registrate){
           $ret = ['msg'=>'Impossibile eliminare, Uscita già registrata'];
        }
        else{

            Delete()->from('uscite_uscita')->where("id = {$id_uscita}");
            $ret = array_merge($_REQUEST,['msg'=>'success']);
        }
    }

    echo json_encode($ret);