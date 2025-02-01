<?php 
    require_once __DIR__.'/../includes.php';
    function need_insert($data,$day,$corso){
        if($date->format('N') !== (int)$day['num'])return false;
        else return Select('true')->from('corsi_planning')->where("
            id_corso={$corso['id']} AND
            row_inizio={$day['inizio']} AND
            row_fine={$day['fine']} AND
            id_terapista={$corso['id_terapista']} AND
            data=
        ")->get_or_false();
    }
    if($_REQUEST['id_corso']&&$_REQUEST['data_inizio']){
        $corso=Select('*')->from('corsi')->where("id={$_REQUEST['id_corso']}")->first();
        $giorni=Select("*, 
            CASE 
                WHEN giorno = 'LUNEDI' THEN 1
                WHEN giorno = 'MARTEDI' THEN 2
                WHEN giorno = 'MERCOLEDI' THEN 3
                WHEN giorno = 'GIOVEDI' THEN 4
                WHEN giorno = 'VENERDI' THEN 5
                WHEN giorno = 'SABATO' THEN 6
                WHEN giorno = 'DOMENICA' THEN 7
                ELSE NULL
            END AS num")->from('corsi_giorni')->where("id_corso={$corso['id']}")->get_or_false();
        if($giorni){
            $start = new DateTime($_REQUEST['data_inizio']);
            $end = new DateTime($start->format('Y-m-t'));
            $interval = new DateInterval('P1D');
            $period = new DatePeriod($start, $interval, $end);
            foreach ($period as $date) {
                foreach($giorni as $day){
                    $data=$date->format('Y-m-d');
                    if (need_insert($data,$day,$corso)) { 
                        Insert([
                            'id_corso'=>$corso['id'],
                            'row_inizio'=>$day['inizio'],
                            'row_fine'=>$day['fine'],
                            'id_terapista'=>$corso['id_terapista'],
                            'data'=>$data,
                            'motivo'=>$corso['corso']
                        ])->into('corsi_planning');
                    }
                }
                
            }
        }
        
    }