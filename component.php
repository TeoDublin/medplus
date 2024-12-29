<?php 
    require 'includes.php';
    $component=request('component');
    require_once "components/{$component}/{$component}.php"; 