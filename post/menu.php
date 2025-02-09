<?php 
    require_once '../includes.php';
    $set=[];
    if(!empty($_POST['user']))$set['user']=$_POST['user'];
    if(!empty($_POST['pasword']))$set['pasword']=$_POST['password'];
    if(!empty($_POST['template']))$set['template']=$_POST['template'];