<?php
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    
    if(!isset($_REQUEST['id']) || !isset($_REQUEST['table']) || !isset($_REQUEST['stato'])){
        throw new Exception("Error Processing Request", 1);
    }

    $stato_pagamento = $_REQUEST['stato'] == 'Saldata' ? 'Saldato' : 'Fatturato';
    $save_sedute = ['stato_pagamento'=>$stato_pagamento];
    $save = ['stato'=>$_REQUEST['stato']];

    if(isset($_REQUEST['data'])){
        if(!null_or_empty($_REQUEST['data'])){
            $save['data'] = $save_sedute['data_pagamento'] = $_REQUEST['data'];
        }
    }

    Update('pagamenti')->set($save)->where("id={$_REQUEST['id']}");

    if($_REQUEST['table'] == 'fatture'){

        Update($_REQUEST['table'])->set($save)->where("id_pagamenti={$_REQUEST['id']}");

        $fatture = Select('*')->from('fatture')->where("id_pagamenti={$_REQUEST['id']}")->get();

        foreach ($fatture as $fattura) {

            $pagamenti_fatture = Select('*')->from('pagamenti_fatture')->where("id_fattura={$fattura['id']}")->get();

            foreach ($pagamenti_fatture as $pagamento_fatture) {
                switch ($pagamento_fatture['origine']) {
                    case 'trattamenti':{
                        Update('percorsi_terapeutici_sedute')->set($save_sedute)->where("id={$pagamento_fatture['id_origine_child']}");
                        break;
                    }
                    case 'corsi':{
                        Update('corsi_pagamenti')->set($save_sedute)->where("id={$pagamento_fatture['id_origine_child']}");
                        break;
                    }                    
                }
            }
        }

    }
    else{

        if(isset($_REQUEST['data'])){
            Update($_REQUEST['table'])->set(['data'=>$_REQUEST['data']])->where("id_pagamenti={$_REQUEST['id']}");
        }

        foreach (Select('*')->from($_REQUEST['table'])->where("id_pagamenti={$_REQUEST['id']} AND origine = 'trattamenti'")->get() as $pagamento ) {
            Update('percorsi_terapeutici_sedute')->set($save_sedute)->where("id={$pagamento['id_origine_child']}");
        }

        foreach (Select('*')->from($_REQUEST['table'])->where("id_pagamenti={$_REQUEST['id']} AND origine = 'corsi'")->get() as $pagamento ) {
            Update('corsi_pagamenti')->set($save_sedute)->where("id={$pagamento['id_origine_child']}");
        }

    }

    
    