<?php 
    require_once __DIR__.'/../includes.php';

    foreach(Select('*')->from('corsi')->where('deleted=0')->get_n_flush() as $corso){
        if(($giorni=_giorni($corso['id']))){
            $start = new DateTime(now('Y-m-d'));
            $end = clone $start;
            $end->add(new DateInterval('P30D'));
            $interval = new DateInterval('P1D');
            $period = new DatePeriod($start, $interval, $end);
            Corsiplanning::insert_corsi_planning($period,$giorni,$corso);
        }
    }