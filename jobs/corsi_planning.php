<?php 
    require_once __DIR__.'/../includes.php';
    function _giorni($id_corso){
        return Select("*, 
            CASE 
                WHEN giorno = 'LUNEDI' THEN 1
                WHEN giorno = 'MARTEDI' THEN 2
                WHEN giorno = 'MERCOLEDI' THEN 3
                WHEN giorno = 'GIOVEDI' THEN 4
                WHEN giorno = 'VENERDI' THEN 5
                WHEN giorno = 'SABATO' THEN 6
                WHEN giorno = 'DOMENICA' THEN 7
                ELSE NULL
            END AS num")->from('corsi_giorni')->where("id_corso={$id_corso}"
        )->get_or_false();
    }
    function _is_not_the_cron(){
        return $_REQUEST['id_corso'] && $_REQUEST['data_inizio'] && $_REQUEST['scadenza'];
    }
    if (_is_not_the_cron()) {
        $corso = Select('*')->from('corsi')->where("id={$_REQUEST['id_corso']}")->first();
        $now = now('Y-m-d');
        $future_date = (new DateTime($now))->add(new DateInterval('P60D'))->format('Y-m-d');
        Delete()->from('corsi_planning')->where("id_corso={$corso['id']} AND data >= '{$_REQUEST['data_inizio']}' AND data <= '{$future_date}'");
        if (($giorni = _giorni($_REQUEST['id_corso']))) {
            $start = new DateTime($_REQUEST['data_inizio']);
            $end = new DateTime($future_date);
            $interval = new DateInterval('P1D');
            $period = new DatePeriod($start, $interval, $end->add($interval));
            Corsiplanning::insert_corsi_planning($period,$giorni,$corso);
            foreach ($_REQUEST['clienti'] as $cliente) {
                $data = new DateTime(date(now("Y-m-{$_REQUEST['scadenza']}")));
                $data->modify('+1 month');
                Corsiplanning::insert_corsi_pagamenti(
                    $cliente['data_inizio'],
                    $data->format('Y-m-d'),
                    $_REQUEST['scadenza'],
                    [
                        'id_cliente'=>$cliente['cliente'],
                        'id_corso'=>$_REQUEST['id_corso'],
                        'prezzo_tabellare'=>$_REQUEST['prezzo'],
                        'prezzo'=>$cliente['prezzo'],
                    ]
                );
            }
        }
    }
    else{
        foreach(Select('*')->from('corsi')->where('deleted=0')->get_n_flush() as $corso){
            if(($giorni=_giorni($corso['id']))){
                $start = new DateTime(now('Y-m-d'));
                $end = clone $start;
                $end->add(new DateInterval('P30D'));
                $interval = new DateInterval('P1D');
                $period = new DatePeriod($start, $interval, $end);
                Corsiplanning::insert_corsi_planning($period,$giorni,$corso);
                foreach(Select('*')->from('corsi_classi')->where("id_corso={$corso['id']}")->get_n_flush() as $cliente){
                    $data = new DateTime(date("Y-m-{$corso['scadenza']}"));
                    $data->modify("+2 month");
                    Corsiplanning::insert_corsi_pagamenti(
                        $cliente['data_inizio'],
                        $data->format("Y-m-d"),
                        $corso['scadenza'],
                        [
                            'id_cliente'=>$cliente['id_cliente'],
                            'id_corso'=>$cliente['id_corso'],
                            'prezzo_tabellare'=>$corso['prezzo'],
                            'prezzo'=>$cliente['prezzo'],
                        ]
                    );
                }
            }
        }
    }