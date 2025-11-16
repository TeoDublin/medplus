<?php 
    require_once '../includes.php';

    switch ($_REQUEST['table']) {
        case 'fatture':{

            $fatture = Select('*')->from('fatture')->where("id_pagamenti={$_REQUEST['id']}")->first();
            Insert(['index'=>$fatture['index']])->ignore()->into('fatture_eliminate');
            $pagamenti_fatture=Select('*')->from('pagamenti_fatture')->where("id_fattura={$fatture['id']}")->get();

            foreach ($pagamenti_fatture as $pagamento) {
                switch ($pagamento['origine']) {
                    case 'trattamenti':
                        $percorsi_terapeutici_sedute=Select('*')->from('percorsi_terapeutici_sedute')->where("id={$pagamento['id_origine_child']}")->first_or_false();

                        if(!$percorsi_terapeutici_sedute){
                            throw new Exception("Error Processing Request", 1);
                        }

                        Update('percorsi_terapeutici_sedute')->set([
                            'data_pagamento'=>'',
                            'tipo_pagamento'=>'',
                            'saldato'=>0,
                            'stato_pagamento'=>'Pendente'
                        ])
                        ->where("id={$percorsi_terapeutici_sedute['id']}");

                        break;
                    case 'corsi':{

                        Update('corsi_pagamenti')->set([
                            'data_pagamento'=>'',
                            'tipo_pagamento'=>'',
                            'stato_pagamento'=>'Pendente'
                        ])->where("id={$pagamento['id_origine_child']}");

                        break;
                    }
                }
            }


            break;
        }
        default:{
        
            $pagamenti=Select('*')->from("pagamenti_{$_REQUEST['table']}")->where("id_pagamenti={$_REQUEST['id']}")->get();

            foreach ($pagamenti as $pagamento) {
                switch ($pagamento['origine']) {
                    case 'trattamenti':{
                        $percorsi_terapeutici_sedute=Select('*')->from('percorsi_terapeutici_sedute')->where("id={$pagamento['id_origine_child']}")->first_or_false();

                        if(!$percorsi_terapeutici_sedute){
                            throw new Exception("Error Processing Request", 1);
                        }

                        Update('percorsi_terapeutici_sedute')->set([
                            'data_pagamento'=>'',
                            'tipo_pagamento'=>'',
                            'saldato'=>0,
                            'stato_pagamento'=>'Pendente'
                        ])
                        ->where("id={$percorsi_terapeutici_sedute['id']}");

                        break;
                    }
                    case 'corsi':{

                        Update('corsi_pagamenti')->set([
                            'data_pagamento'=>'',
                            'tipo_pagamento'=>'',
                            'stato_pagamento'=>'Pendente'
                        ])
                        ->where("id={$pagamento['id_origine_child']}");

                        break;
                    }
                }
            }
        }
    }

    Delete()->from('pagamenti')->where("id={$_REQUEST['id']}");
    