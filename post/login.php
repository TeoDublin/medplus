<?php
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    global $session; 
    $session = Session::getInstance();
    if (!$session->isLoggedIn()) {
        
    }