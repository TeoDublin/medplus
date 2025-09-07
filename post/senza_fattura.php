<?php
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    $valore=(int)$_REQUEST['_data']['valore'];
    foreach ($_REQUEST['percorsi'] as $key=>$value) {
        if($valore>0){
            $obj=Select('*')->from($value['view'])->where("id={$value['id']}")->first();
            switch($value['view']){
                case 'corsi_pagamenti':{
                    $origine='corsi';
                    $id_origine=$obj['id_corso'];
                    $id_origine_child=$obj['id'];
                    break;
                }
                case 'view_sedute':{
                    $origine='trattamenti';
                    $id_origine=$obj['id_percorso'];
                    $id_origine_child=$obj['id'];
                    break;
                }
            }
            
            $debit=(double)$obj['prezzo']<=$valore?(double)$obj['prezzo']:$valore;
            Insert([
                'origine'=>$origine,
                'id_origine'=>$id_origine,
                'id_origine_child'=>$id_origine_child,
                'id_cliente'=>$_REQUEST['_data']['id_cliente'],
                'valore'=>$debit,
                'data'=>$_REQUEST['_data']['data'],
                'note'=>$_REQUEST['_data']['note']?:'-'
            ])->into('pagamenti_senza_fattura')->get();
            $valore-=$debit;
            if($origine=='trattamenti'){
                Sedute()->refresh($obj['id_percorso'],$_REQUEST['_data']['data'],'Senza Fattura');
            }
        }
    }
