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
                
                Delete()->from('percorsi_terapeutici_sedute')->where("id={$percorsi_terapeutici_sedute['id']}");

                if(!isset($percorsi[$percorsi_terapeutici_sedute['id_percorso']])){
                    $percorsi[$percorsi_terapeutici_sedute['id_percorso']]=0;
                }
                
                $percorsi[$percorsi_terapeutici_sedute['id_percorso']] += $percorsi_terapeutici_sedute['prezzo'];

                break;
            }
            case 'corsi_pagamenti':{
                Delete()->from('corsi_pagamenti')->where("id={$value['id']}");
                break;
            }
        }
    }

    foreach ($percorsi as $id => $remove) {
        Update('percorsi_terapeutici')->set(['prezzo'=>"`prezzo` - {$remove}"])->where("id={$id}");
        $index=1;
        foreach(Select('*')->from('percorsi_terapeutici_sedute')->where("id_percorso={$id}")->orderby('`index` ASC')->get() as $pts){
            if($pts['index']!=$index){
                Update('percorsi_terapeutici_sedute')->set(['index'=>$index])->where("id={$pts['id']}");
            }
            $index++;
        }
    }