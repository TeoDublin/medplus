<?php
    require 'includes.php';
    $component=request('component');
    if($_REQUEST['tab']&&!$_REQUEST['reset']){
        require_once "page_components/{$component}/{$_REQUEST['tab']}/{$_REQUEST['tab']}.php";
    }
    else{
        require_once "page_components/{$component}/ctrl.php";
        require_once "page_components/{$component}/view.php";
    }