<?php
    $files = glob('class*.php');
    foreach ($files as $file) require_once $file;

    function html(){
        return new html();
    }
    function sql(){
        return new sql();
    }