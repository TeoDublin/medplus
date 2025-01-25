<?php
    $_REQUEST['skip_cookie']=true;
    require '../includes.php';
    $valore=(int)$_REQUEST['_data']['valore'];
    foreach ($_REQUEST['percorsi'] as $percorso) {
        if($valore>0){
            $debit=(int)$percorso['non_fatturato']<=$valore?(int)$percorso['non_fatturato']:$valore;
            Insert([
                'id_percorso'=>$percorso['id_percorso'],
                'id_cliente'=>$_REQUEST['_data']['id_cliente'],
                'valore'=>$debit,
                'note'=>$_REQUEST['_data']['note']?:'-'
            ])->into('percorsi_pagamenti_senza_fattura')->get();
            $valore-=$debit;
        }
    }