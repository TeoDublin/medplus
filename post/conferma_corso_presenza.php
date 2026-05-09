<?php 
    require_once __DIR__.'/../includes.php';
    $save=[
        'id_corso'=>$_REQUEST['id_corso'],
        'id_cliente'=>$_REQUEST['id_cliente'],
        'scadenza'=>$_REQUEST['scadenza'],
        'prezzo'=>$_REQUEST['prezzo'],
        'prezzo_tabellare'=>$_REQUEST['prezzo_tabellare'],
    ];

    if( $_REQUEST['prezzo'] == 0 ){
        $save['stato_pagamento'] = 'Esente';
        $save['data_pagamento'] = $_REQUEST['scadenza'];
        $save['tipo_pagamento'] = 'Esente';
    }

    if($corsi_sospensioni=Select('*')
        ->from('corsi_sospensioni')
        ->where("id_corso={$_REQUEST['id_corso']} and id_cliente={$_REQUEST['id_cliente']} and mese={$_REQUEST['mese']} and anno={$_REQUEST['anno']}")->first_or_false()
    ){
        Delete()->from('corsi_sospensioni')->where("id={$corsi_sospensioni['id']}");
    }
    if(($corsi_pagamenti=Select('*')
        ->from('corsi_pagamenti')
        ->where("id_cliente={$_REQUEST['id_cliente']}")
        ->and("id_corso={$_REQUEST['id_corso']}")
        ->and("scadenza='{$_REQUEST['scadenza']}'")
        ->first_or_false()
    )){
        Update('corsi_pagamenti')->set($save)->where("id={$corsi_pagamenti['id']}");
    }
    else Insert($save)->into('corsi_pagamenti');