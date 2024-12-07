<?php
    $_REQUEST['skip_cookie']=true;
    require '../includes.php';
    $sedute=request('sedute',0);
    $prezzo=request('prezzo',0);
    for ($i=0; $i < $sedute; $i++) { 
        Insert(array_merge($_REQUEST,['index'=>$i+1]))->into('sedute')->get();
    }