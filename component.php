<?php 
    require_once 'includes.php';
    $component=request('component');
    require_once "components/{$component}/{$component}.php"; 