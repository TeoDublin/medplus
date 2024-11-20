<?php
    function _tab($tab):bool{
        return ($_REQUEST['tab']??'anagrafica')==$tab;
    }
    switch ($_POST['action']) {
        case 'select-nominativo':
            echo Select('*')->from('clienti')->where("nominativo like '%".str_scape($_POST['nominativo'])."%'")->json();
            break;
    }