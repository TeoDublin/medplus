<?php 
    require_once 'includes.php';
    require_once 'includes/session.php';
    $component=request('component');
    require_once "components/{$component}/{$component}.php"; 