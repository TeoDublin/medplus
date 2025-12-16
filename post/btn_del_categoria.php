<?php 
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    
    if(null_or_empty($_REQUEST['id_categoria'])){
        echo 'Seleziona qualcosa';
    }
    else{
        $uscite_registrate = Select('*')->from('uscite_registrate')->where("id_categoria = {$_REQUEST['id_categoria']}")->first_or_false();

        if($uscite_registrate){
           echo 'Impossibile eliminare, Uscita già registrata';
        }
        else{

            Delete()->from('uscite_categoria')->where("id = {$_REQUEST['id_categoria']}");
            echo 'success';
        }
    }