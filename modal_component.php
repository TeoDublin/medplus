<?php
    require 'includes.php';
    $component=request('component');
    require_once "modal_component/{$component}/{$component}.php";