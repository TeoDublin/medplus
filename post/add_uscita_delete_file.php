<?php
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    if(is_file($_REQUEST['path'])){
        unlink($_REQUEST['path']);
    }