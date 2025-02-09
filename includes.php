<?php
    require_once 'includes/constants.php';
    foreach (glob(__DIR__ . '/class/obj_class/*.php') as $file) require_once $file;
    foreach (glob(__DIR__ . '/class/static_class/*.php') as $file) require_once $file;
    foreach (glob(__DIR__ . '/class/singleton/*.php') as $file) require_once $file;
    require_once 'includes/class.php';
    require_once 'includes/functions.php';
    require_once 'includes/cookies.php';