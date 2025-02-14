<?php 
    require_once __DIR__.'/../includes.php';
    $today=now('Y-m-d');
    $now=now('H:m:i');
    $conclusi=Select('p.*')
        ->from('view_planning','p')
        ->left_join('planning_row pr ON p.row_fine = pr.id')
        ->where("origin='Seduta'")
        ->and("pr.ora < '{$now}'")
        ->and("p.data='{$today}'")
        ->get();
    foreach($conclusi as $conclusa){
        Update('percorsi_terapeutici_sedute_prenotate')->set(['stato_prenotazione'=>'Conclusa'])->where("id={$conclusa['id']}");
    }