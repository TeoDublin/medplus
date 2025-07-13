<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

$_REQUEST['skip_cookie'] = true;
require_once '../includes.php';

function _selected($view_utenti_presenze){

    if(!$view_utenti_presenze)return 'Inizio Giornata';
    else{
        switch ($view_utenti_presenze[0]['nome']) {
            case 'Inizio Giornata': return 'Pausa Inizio';
            case 'Pausa Inizio': return 'Pausa Fine';
            case 'Pausa Fine': return 'Fine Giornata';
            case 'Fine Giornata': return 'done';
            default:return 'Inizio Giornata';
        }
    }
}

$today=now('Y-m-d');
$view_utenti_presenze=Select('*')->from('view_utenti_presenze')->where("`data`='{$today}'")->orderby("`data` DESC")->get_or_false();

$ret=['enums'=>Enum('utenti_presenze','nome')->get()];

$ret['selected']=_selected($view_utenti_presenze);

if($view_utenti_presenze){
    foreach($view_utenti_presenze as $saved){
        $ret['saved'][]=$saved;
    }
}

echo json_encode($ret);
