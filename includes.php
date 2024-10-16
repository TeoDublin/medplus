<?php
    $files = glob(__DIR__ . '/class/*.php');
    foreach ($files as $file) require_once $file;
    $files = glob(__DIR__ . '/model/*.php');
    foreach ($files as $file) require_once $file;
    require 'includes/class.php';
    require 'includes/functions.php';