<?php 
    require '../includes.php';
    Delete()->from($_REQUEST['table'])->where("id={$_REQUEST['id']}");