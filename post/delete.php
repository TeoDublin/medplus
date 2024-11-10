<?php 
    require '../includes.php';
    Delete($_REQUEST['id'])->from($_REQUEST['table']);