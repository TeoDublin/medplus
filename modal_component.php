<?php
    $_REQUEST['skip_cookie']=true;
    require_once 'includes.php';
    $component=request('component');
    require_once "modal_component/{$component}/{$component}.php";