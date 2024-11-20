<?php
    require 'includes.php';
    $component=request('name');
    require_once "page_components/{$component}/ctrl.php";
    if($_REQUEST['test'])require 'includes/header.php';
    require_once "page_components/{$component}/view.php";
    if($_REQUEST['test'])require 'includes/footer.php';