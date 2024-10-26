<?php 
    function _tab($tab):bool{
        return cookie('tab','trattamenti')==$tab;
    }    
    if(is_submit()){
        switch (cookie('tab','trattamenti')) {
            case 'trattamenti':
                $post=clean_post();
                switch ($_REQUEST['action']) {
                    case 'insert':
                        Trattamenti()->insert($post);
                        break;
                    case 'update':
                        Trattamenti()->update($post);
                        break;
                    case 'delete':
                        Trattamenti()->delete($post['id']);
                        break;                        
                    default:
                        break;
                }
                break;
            case 'terapisti':
                $post=clean_post();
                switch ($_REQUEST['action']) {
                    case 'insert':
                        Terapisti()->insert($post);
                        break;
                    case 'update':
                        Terapisti()->update($post);
                        break;
                    case 'delete':
                        Terapisti()->delete($post['id']);
                        break;                        
                    default:
                        break;
                }
                break;
        }
        redirect("impostazioni.php");
        exit();
    }