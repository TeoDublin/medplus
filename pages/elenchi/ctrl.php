<?php 
    function _tab_name():string{
        return $_REQUEST['tab']??'trattamenti';
    }
    function _tab($tab):bool{
        return _tab_name()==$tab;
    }    
    if(is_submit()){
        switch (_tab_name()) {
            case 'trattamenti':
                Trattamenti()->insert(clean_post());
                break;
            default:
                # code...
                break;
        }
        redirect("elenchi.php");
        exit();
    }