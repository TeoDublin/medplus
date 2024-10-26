<?php 
    function _tab($tab):bool{
        return cookie('tab','planning')==$tab;
    }    
    if(is_submit()){
        switch (cookie('tab','planning')) {
            case 'planning':
                $post=clean_post();
                switch ($_REQUEST['action']) {
                    case 'insert':
                        Prenotazioni()->insert($post);
                        break;
                    case 'update':
                        Prenotazioni()->update($post);
                        break;
                    case 'delete':
                        Prenotazioni()->delete($post['id']);
                        break;
                    default:
                        break;
                }
                break;
        }
        redirect("prenotazioni.php");
        exit();
    }