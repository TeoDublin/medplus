<?php
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    $percorsi=[];
    foreach ($_REQUEST['data'] as $value) {
        switch ($value['view']) {
            case 'view_sedute':{

                $percorsi_terapeutici_sedute=Select('*')->from('percorsi_terapeutici_sedute')->where("id={$value['id']}")->first_or_false();
                
                if(!$percorsi_terapeutici_sedute){
                    http_response_code(500);
                    echo 'view_sedute non puo essere vuoto';
                    exit;
                }
                
                Update('percorsi_terapeutici_sedute')->set(['prezzo'=>$_REQUEST['prezzo']])->where("id={$percorsi_terapeutici_sedute['id']}");

                $difference = $_REQUEST['prezzo'] - $percorsi_terapeutici_sedute['prezzo'];

                if(!isset($percorsi[$percorsi_terapeutici_sedute['id_percorso']])){
                    $percorsi[$percorsi_terapeutici_sedute['id_percorso']]=0;
                }
                
                $percorsi[$percorsi_terapeutici_sedute['id_percorso']] += $difference;

                break;
            }
            case 'corsi_pagamenti':{
                Update('corsi_pagamenti')->set(['prezzo'=>$_REQUEST['prezzo']])->where("id={$value['id']}");
                break;
            }
        }
    }

    foreach ($percorsi as $id => $add) {
        Update('percorsi_terapeutici')->set(['prezzo'=>"`prezzo` + {$add}"])->where("id={$id}");
    }