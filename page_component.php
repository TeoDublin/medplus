<?php
    require 'includes.php';
    $component=request('name');
    require_once "page_components/{$component}/ctrl.php";
    require_once "page_components/{$component}/view.php";