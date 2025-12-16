<?php 
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    
    if(null_or_empty($_REQUEST['id_indirizzato_a'])){
        echo 'Seleziona qualcosa';
    }
    else{
        $uscite_registrate = Select('*')->from('uscite_registrate')->where("id_indirizzato_a = {$_REQUEST['id_indirizzato_a']}")->first_or_false();

        if($uscite_registrate){
           echo 'Impossibile eliminare, Uscita già registrata';
        }
        else{

            Delete()->from('uscite_indirizzato_a')->where("id = {$_REQUEST['id_indirizzato_a']}");
            echo 'success';
        }
    }