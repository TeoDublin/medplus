<?php 
    require_once '../includes.php';
    Delete()->from($_REQUEST['table'])->where("id={$_REQUEST['id']}");