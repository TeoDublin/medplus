<?php
    require 'includes.php';
    $component=request('name');
    require_once "components/{$component}/ctrl.php";
    require_once "components/{$component}/view.php";