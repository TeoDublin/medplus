<?php 
    function _tab($tab):bool{
        return cookie('tab','anagrafica')==$tab;
    }    
    if(is_submit()){
        switch (cookie('tab','anagrafica')) {
            case 'anagrafica':
                $post=clean_post();
                switch ($_REQUEST['action']) {
                    case 'insert':
                        Utenti()->insert($post);
                        break;
                    case 'update':
                        Utenti()->update($post);
                        break;
                    case 'delete':
                        Utenti()->delete($post['id']);
                        break;                        
                    default:
                        break;
                }
                break;
        }
        redirect("utenti.php");
        exit();
    }