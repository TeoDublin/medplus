<?php 
    require 'includes.php';
    $component=request('name');
    require_once "components/{$component}/{$component}.php"; 