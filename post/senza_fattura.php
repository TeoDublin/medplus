<?php
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    $valore=(double)$_REQUEST['_data']['valore'];
    $inps =  0;
    $bollo = 0;
    $bnw = isset($_REQUEST['_data']['bnw']) ? $_REQUEST['_data']['bnw'] : 'da definire';
    $stato = isset($_REQUEST['_data']['metodo']) && $_REQUEST['_data']['metodo'] == 'Bonifico' ? 'Pendente' : 'Saldata';

    $id_pagamenti = Insert([
        'id_cliente'=>$_REQUEST['_data']['id_cliente'],
        'origine'=>'senza_fattura',
        'metodo'=>$_REQUEST['_data']['metodo'],
        'data'=>$_REQUEST['_data']['data'],
        'imponibile'=>$valore,
        'inps'=> $inps,
        'bollo' => $bollo,
        'stato' => $stato,
        'totale' => ( $valore + $inps + $bollo ),
        'bnw'=>$bnw
    ])->into('pagamenti')->get();

    foreach ($_REQUEST['percorsi'] as $key=>$value) {
        if($valore>0){

            $obj=Select('*')->from($value['view'])->where("id={$value['id']}")->first();

            $prezzo = (double)$obj['prezzo'];

            $saldato = $prezzo <= ($valore + (double)$obj['saldato']) ? ($prezzo - (double)$obj['saldato']) : $valore;

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

                    Update('percorsi_terapeutici_sedute')->set([
                        'data_pagamento'=>$_REQUEST['_data']['data'],
                        'tipo_pagamento'=>'Senza Fattura',
                        'saldato'=>($saldato + (double)$obj['saldato']),
                        'stato_pagamento'=>($_REQUEST['_data']['metodo'] == 'Bonifico' ? 'Fatturato' : 'Saldato')
                    ])->where("id={$obj['id']}");
                    break;
                }
            }
            
            Insert([
                'origine'=>$origine,
                'id_origine'=>$id_origine,
                'id_origine_child'=>$id_origine_child,
                'id_cliente'=>$_REQUEST['_data']['id_cliente'],
                'id_pagamenti'=>$id_pagamenti,
                'valore'=>$saldato,
                'data'=>$_REQUEST['_data']['data'],
                'metodo'=>$_REQUEST['_data']['metodo'],
                'note'=>$_REQUEST['_data']['note']?:'-'
            ])->into('pagamenti_senza_fattura')->get();

            $valore= $valore - $saldato;

        }
    }
