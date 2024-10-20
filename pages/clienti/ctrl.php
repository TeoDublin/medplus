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
                        Clienti()->insert($post);
                        break;
                    case 'update':
                        Clienti()->update($post);
                        break;
                    case 'delete':
                        Clienti()->delete($post['id']);
                        break;
                    default:
                        break;
                }
                break;
        }
        redirect("clienti.php");
        exit();
    }