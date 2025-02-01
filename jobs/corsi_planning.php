<?php 
    require_once __DIR__.'/../includes.php';
    function giorni($id_corso){
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
    if($_REQUEST['id_corso']&&$_REQUEST['data_inizio']){
        $corso=Select('*')->from('corsi')->where("id={$_REQUEST['id_corso']}")->first();
        $now=now('Y-m-d');
        Delete()->from('corsi_planning')->where("id_corso={$corso['id']} AND data >= '{$now}'");
        if(($giorni=giorni($_REQUEST['id_corso']))){
            $start = new DateTime($_REQUEST['data_inizio']);
            $end = clone $start;
            $end->add(new DateInterval('P30D'));
            $interval = new DateInterval('P1D');
            $period = new DatePeriod($start, $interval, $end);
            foreach ($period as $date) {
                foreach($giorni as $day){
                    if ((int)$date->format('N') == $day['num']) { 
                        Insert([
                            'id_corso'=>$corso['id'],
                            'row_inizio'=>$day['inizio'],
                            'row_fine'=>$day['fine'],
                            'id_terapista'=>$corso['id_terapista'],
                            'data'=>$date->format('Y-m-d'),
                            'motivo'=>$corso['corso']
                        ])->into('corsi_planning')->flush();
                    }
                }
                
            }
        }    
    }
    else{
        foreach(Select('*')->from('corsi')->where('deleted=0')->get() as $corso){
            if(($giorni=giorni($corso['id']))){
                $start = new DateTime(now('Y-m-d'));
                $end = clone $start;
                $end->add(new DateInterval('P30D'));
                $interval = new DateInterval('P1D');
                $period = new DatePeriod($start, $interval, $end);
                foreach ($period as $date) {
                    foreach($giorni as $day){
                        if ((int)$date->format('N') == $day['num']) { 
                            $data=$date->format('Y-m-d');
                            if(!Select('*')->from('corsi_planning')->where("
                                id_corso={$corso['id']} AND
                                row_inizio={$day['inizio']} AND
                                row_fine={$day['fine']} AND
                                id_terapista={$corso['id_terapista']} AND
                                data='{$data}'
                            ")->get_or_false()){
                                Insert([
                                    'id_corso'=>$corso['id'],
                                    'row_inizio'=>$day['inizio'],
                                    'row_fine'=>$day['fine'],
                                    'id_terapista'=>$corso['id_terapista'],
                                    'data'=>$data,
                                    'motivo'=>$corso['corso']
                                ])->into('corsi_planning')->flush();
                            }
                        }
                    }
                }
            }
        }
    }