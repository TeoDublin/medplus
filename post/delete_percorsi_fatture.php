<?php 
    require_once '../includes.php';
    switch ($_REQUEST['table']) {
        case 'fatture':
            $trattamenti=Select('*')->from('pagamenti_fatture')->where("id_fattura={$_REQUEST['id']} AND origine='trattamenti'")->get();
            break;
        
        default:
            $trattamenti=Select('*')->from($_REQUEST['table'])->where("id={$_REQUEST['id']} AND origine='trattamenti'")->get();
            break;
    }
    Delete()->from($_REQUEST['table'])->where("id={$_REQUEST['id']}");
    foreach ($trattamenti as $trattamento) {
        Sedute()->refresh($trattamento['id_origine']);
    }