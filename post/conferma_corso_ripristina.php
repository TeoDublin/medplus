<?php 
    require_once __DIR__.'/../includes.php';
    if(($corsi_pagamenti=Select('*')
        ->from('corsi_pagamenti')
        ->where("id_cliente={$_REQUEST['id_cliente']}")
        ->and("id_corso={$_REQUEST['id_corso']}")
        ->and("scadenza='{$_REQUEST['scadenza']}'")
        ->first_or_false()
    )){
        Delete()->from('corsi_pagamenti')->where("id={$corsi_pagamenti['id']}");
    }

    if($corsi_sospensioni=Select('*')
        ->from('corsi_sospensioni')
        ->where("id_corso={$_REQUEST['id_corso']} and id_cliente={$_REQUEST['id_cliente']} and mese={$_REQUEST['mese']} and anno={$_REQUEST['anno']}")->first_or_false()
    ){
        Delete()->from('corsi_sospensioni')->where("id={$corsi_sospensioni['id']}");
    }