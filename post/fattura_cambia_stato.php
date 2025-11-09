<?php
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    
    if(!isset_n_valid($_REQUEST['id'])){
        throw new Exception("Error Processing Request", 1);
    }

    Update('pagamenti')->set(['stato'=>$_REQUEST['stato']])->where("id={$_REQUEST['id']}");

    Update('fatture')->set(['stato'=>$_REQUEST['stato']])->where("id_pagamenti={$_REQUEST['id']}");

    $fatture = Select('*')->from('fatture')->where("id_pagamenti={$_REQUEST['id']}")->get();

    $stato_pagamento = $_REQUEST['stato'] == 'Saldata' ? 'Saldato' : 'Fatturato';

    foreach ($fatture as $fattura) {

        $pagamenti_fatture = Select('*')->from('pagamenti_fatture')->where("id_fattura={$fattura['id']}")->get();

        foreach ($pagamenti_fatture as $pagamento_fatture) {
            if($pagamento_fatture['origine']=='trattamenti'){
                Update('percorsi_terapeutici_sedute')->set(['stato_pagamento'=>$stato_pagamento])->where("id={$pagamento_fatture['id_origine_child']}");
            }
        }
    }
    
    