<?php 
$_REQUEST['skip_cookie']=true;
require_once 'includes.php';
$ret=password_hash($_REQUEST['password'],PASSWORD_DEFAULT);
var_dump($ret);