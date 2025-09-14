<?php 
    require_once '../includes.php';

    switch ($_REQUEST['table']) {
        case 'fatture':
            $trattamenti=Select('*')->from('pagamenti_fatture')->where("id_fattura={$_REQUEST['id']} AND origine='trattamenti'")->get();
            $index=Select('*')->from('fatture')->where("id={$_REQUEST['id']}")->col('index');
            Insert(['index'=>$index])->ignore()->into('fatture_eliminate');

            $pagamenti_fatture=Select('*')->from('pagamenti_fatture')->where("id_fattura={$_REQUEST['id']}")->get();

            foreach ($pagamenti_fatture as $pagamento) {
                switch ($pagamento['origine']) {
                    case 'trattamenti':
                        $percorsi_terapeutici_sedute=Select('*')->from('percorsi_terapeutici_sedute')->where("id={$pagamento['id_origine_child']}")->first_or_false();

                        if(!$percorsi_terapeutici_sedute){
                            throw new Exception("Error Processing Request", 1);
                        }

                        $pagamenti_seduta=Select('*')->from('pagamenti_fatture')->where("id_origine_child={$percorsi_terapeutici_sedute['id']}")->orderby('`timestamp` DESC')->get();
                        if(count($pagamenti_seduta)>1){
                            $data_pagamento=$pagamenti_seduta[1]['data'];
                            $tipo_pagamento=$pagamenti_seduta[1]['tipo_pagamento'];
                        }
                        else{
                            $data_pagamento='';
                            $tipo_pagamento='';
                        }

                        $saldato=(double)$percorsi_terapeutici_sedute['saldato']-(double)$pagamento['importo'];
                        if($saldato<0){
                            $saldato = 0;
                        }

                        Update('percorsi_terapeutici_sedute')->set([
                            'data_pagamento'=>$data_pagamento,
                            'tipo_pagamento'=>$tipo_pagamento,
                            'saldato'=>$saldato,
                            'stato_pagamento'=>($saldato > 0 ? 'Parziale' : 'Pendente')
                        ])
                        ->where("id={$percorsi_terapeutici_sedute['id']}");

                        break;
                    case 'corsi':
                        # code...
                        break;
                }
            }


            break;
        
        default:
        
            $pagamento=Select('*')->from($_REQUEST['table'])->where("id={$_REQUEST['id']}")->first();

            switch ($pagamento['origine']) {
                case 'trattamenti':
                    $percorsi_terapeutici_sedute=Select('*')->from('percorsi_terapeutici_sedute')->where("id={$pagamento['id_origine_child']}")->first_or_false();

                    if(!$percorsi_terapeutici_sedute){
                        throw new Exception("Error Processing Request", 1);
                    }

                    $pagamenti_seduta=Select('*')->from($_REQUEST['table'])->where("id_origine_child={$percorsi_terapeutici_sedute['id']}")->orderby('`data` DESC')->get();
                    if(count($pagamenti_seduta)>1){
                        $data_pagamento=$pagamenti_seduta[1]['data'];
                        $tipo_pagamento=$pagamenti_seduta[1]['tipo_pagamento'];
                    }
                    else{
                        $data_pagamento='';
                        $tipo_pagamento='';
                    }

                    $saldato=(double)$percorsi_terapeutici_sedute['saldato']-(double)$pagamento['valore'];
                    if($saldato<0){
                        $saldato = 0;
                    }

                    Update('percorsi_terapeutici_sedute')->set([
                        'data_pagamento'=>$data_pagamento,
                        'tipo_pagamento'=>$tipo_pagamento,
                        'saldato'=>$saldato,
                        'stato_pagamento'=>($saldato > 0 ? 'Parziale' : 'Pendente')
                    ])
                    ->where("id={$percorsi_terapeutici_sedute['id']}");

                    break;
                case 'corsi':
                    # code...
                    break;
            }
            break;
    }

    Delete()->from($_REQUEST['table'])->where("id={$_REQUEST['id']}");
    