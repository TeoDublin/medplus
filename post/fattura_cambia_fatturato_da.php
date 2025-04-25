<?php
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    Update('fatture')->set(['fatturato_da'=>$_REQUEST['fatturato_da']])->where("id={$_REQUEST['id']}");