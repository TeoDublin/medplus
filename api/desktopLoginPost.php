<?php
date_default_timezone_set('Europe/Rome');
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

$_REQUEST['skip_cookie'] = true;
require_once '../includes.php';

function _categoria(){
    $ret=[
        'Inizio Giornata'=>'log',
        'Pausa Pranzo Inizio'=>'pausa',
        'Pausa Pranzo Fine'=>'pausa',
        'Fine Giornata'=>'log'
    ];
    return $ret[$_POST['selected']];
}

$today=now('Y-m-d');
$view_utenti_presenze=Select('*')->from('view_utenti_presenze')->where("`data`='{$today}'")->orderby("`data` DESC")->get();

$ret=['response'=>'Registrato con successo'];
$has_error = false;

foreach ($view_utenti_presenze as $vup) {
    if($vup['nome']==$_POST['selected']){
        $ret['response']='ERORE! Non puoi ripetere lo stesso motivo in una sola giornata';
        $has_error = true;
        break;
    }
}

if(!$has_error&&isset($_POST['selected'])){
    Insert([
        'id_utenti'=>5,
        'categoria'=>_categoria(),
        'nome'=>$_POST['selected'],
        'data'=>$today,
        'orario'=>now('H:i:s')
    ])->into('utenti_presenze');
}
else{
    echo json_encode(['error'=>'not allowed']);
    exit();
}


echo json_encode($ret);
