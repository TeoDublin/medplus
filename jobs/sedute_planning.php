<?php 
    require_once __DIR__.'/../includes.php';
    $now=now('Y-m-d H:m:i');
    $prenotati=Select('p.*')
        ->from('view_planning','p')
        ->where("p.origin IN('Seduta','colloquio')")
        ->and("p.data_fine < '{$now}'")
        ->and("p.stato = 'Prenotata'")
        ->get();
    foreach($prenotati as $prenotato){
        Update('percorsi_terapeutici_sedute_prenotate')->set(['stato_prenotazione'=>'Conclusa'])->where("id={$prenotato['id']}")->flush();
    }