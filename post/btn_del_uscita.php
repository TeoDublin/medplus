<?php 
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    
    if(null_or_empty($_REQUEST['id_uscita'])){
        echo 'Seleziona qualcosa';
    }
    else{
        $uscite_registrate = Select('*')->from('uscite_registrate')->where("id_uscita = {$_REQUEST['id_uscita']}")->first_or_false();

        if($uscite_registrate){
           echo 'Impossibile eliminare, Uscita già registrata';
        }
        else{

            Delete()->from('uscite_uscita')->where("id = {$_REQUEST['id_uscita']}");
            echo 'success';
        }
    }