<?php
    $_REQUEST['skip_cookie']=true;
    require '../includes.php';
    $valore=(int)$_REQUEST['_data']['valore'];
    foreach ($_REQUEST['percorsi'] as $percorso) {
        if($valore>0){
            $debit=(int)$percorso['importo']<=$valore?(int)$percorso['importo']:$valore;
            Insert([
                'id_percorso'=>$percorso['id_percorso'],
                'id_cliente'=>$_REQUEST['_data']['id_cliente'],
                'valore'=>$debit
            ])->into('percorsi_pagamenti_senza_fattura')->get();
            $valore-=$debit;
        }
    }