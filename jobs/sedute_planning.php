<?php 
    require_once __DIR__.'/../includes.php';
    $now=now('Y-m-d H:m:i');
    $sedute=Select('p.*')
        ->from('view_planning','p')
        ->where("p.origin = 'seduta'")
        ->and("p.data_fine < '{$now}'")
        ->and("p.stato = 'Prenotata'")
        ->get();

    foreach($sedute as $prenotato){
        Update('percorsi_terapeutici_sedute_prenotate')->set(['stato_prenotazione'=>'Conclusa'])->where("id={$prenotato['id']}")->flush();
    }

    $colloquio=Select('p.*')
        ->from('view_planning','p')
        ->where("p.origin = 'colloquio'")
        ->and("p.data_fine < '{$now}'")
        ->and("p.stato = 'Prenotata'")
        ->get();
    foreach($colloquio as $prenotato){
        Update('colloquio_planning')->set(['stato_prenotazione'=>'Conclusa'])->where("id={$prenotato['id']}")->flush();
    }