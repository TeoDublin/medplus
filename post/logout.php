<?php
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    $session = Session();
    $session->logout();