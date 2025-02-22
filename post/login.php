<?php
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    global $session; 
    $session = Session::getInstance();
    $ret=Select('*')
        ->from('view_utenti')
        ->where("user='{$_REQUEST['username']}'")
        ->first_or_false();
    if(!$ret)echo json_encode(['response'=>'wrong_user']);
    elseif(!$session->login($_REQUEST['username'],$_POST['password'],$ret))echo json_encode(['response'=>'wrong_pass']);
    else echo json_encode(['response'=>'success','home'=>"{$ret['home']}.php"]);