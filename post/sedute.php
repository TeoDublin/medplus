<?php
    $_REQUEST['skip_cookie']=true;
    require '../includes.php';
    $sedute=request('sedute',0);
    $prezzo=request('prezzo',0);
    $prezzo_tabellare=request('prezzo_tabellare',0);
    for ($i=0; $i < $sedute; $i++) { 
        Insert(array_merge($_REQUEST,['index'=>$i+1]))->into('sedute')->get();
    }
    Insert([
        'id_percorso'=>$_REQUEST['id_percorso'],
        'id_cliente'=>$_REQUEST['id_cliente'],
        'prezzo_tabellare'=>$prezzo_tabellare,
        'prezzo'=>$prezzo
    ])->into('percorsi_pagamenti');