<?php 
$_REQUEST['skip_cookie']=true;
require_once 'includes.php';
$ret=password_hash("terapeuta",PASSWORD_DEFAULT);
var_dump($ret);