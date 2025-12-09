<?php
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    $id=request('id');
    $first_date=now('Y-m-d');

    $corso=[
        'id_categoria'=>$_REQUEST['id_categoria'],
        'id_terapista'=>$_REQUEST['id_terapista'],
        'corso'=>$_REQUEST['corso'],
        'prezzo'=>$_REQUEST['prezzo'],
        'scadenza'=>$_REQUEST['scadenza']
    ];

    if($id&&!empty($id)){
        Update('corsi')->set($corso)->where("id={$id}");
    }
    else{
        $id=Insert($corso)->into('corsi')->get();
    }
    
    Delete()->from('corsi_giorni')->where("id_corso={$id}");

    foreach ($_REQUEST['days'] as $day) {
        Insert(['id_corso'=>$id,'giorno'=>$day['giorno'],'inizio'=>$day['inizio'],'fine'=>$day['fine']])->into('corsi_giorni');
    }

    $clienti = [];

    foreach ($_REQUEST['clienti'] as $cliente) {

        if($cliente['data_inizio']<$first_date){
            $first_date=$cliente['data_inizio'];
        }

        $corsi_classi = Select('*')->from('corsi_classi')->where("id_corso={$id} AND id_cliente={$cliente['cliente']}")->first_or_false();

        $params = [
            'id_corso'=>$id,
            'id_cliente'=>$cliente['cliente'],
            'prezzo'=>$cliente['prezzo'],
            'data_inizio'=>$cliente['data_inizio'],
            'bnw'=>$cliente['bnw'],
            'realizzato_da'=>$cliente['realizzato_da'],
        ];

        if(!$corsi_classi){
            Insert($params)->into('corsi_classi');
            $params['prezzo_tabellare'] = $cliente['prezzo'];
            unset($params['data_inizio']);

            $data = new DateTime(date(now("Y-m-{$_REQUEST['scadenza']}")));
            Corsiplanning::insert_corsi_pagamenti(
                $cliente['data_inizio'],
                $data->format('Y-m-d'),
                $_REQUEST['scadenza'],
                [
                    'id_corso'=>$params['id_corso'],
                    'id_cliente'=>$params['id_cliente'],
                    'prezzo'=>$params['prezzo'],
                    'prezzo_tabellare'=>$params['prezzo']
                ]
            );
        }
        else{
            Update('corsi_classi')->set($params)->where("id={$corsi_classi['id']}");
        }

        $clienti[] = $cliente['cliente'];
    }

    $corsi_classi = Select('*')->from('corsi_classi')->where("id_corso={$id}")->get();

    foreach ($corsi_classi as $cc) {
        if(!in_array($cc['id_cliente'],$clienti)){
            Delete()->from('corsi_classi')->where("id={$cc['id']}");
        }
    }

    $corso = Select('*')->from('corsi')->where("id={$id}")->first();
    $now = now('Y-m-d');
    $future_date = (new DateTime($now))->add(new DateInterval('P60D'))->format('Y-m-d');
    Delete()->from('corsi_planning')->where("id_corso={$corso['id']} AND data >= '{$first_date}' AND data <= '{$future_date}'");
    
    if (($giorni = _giorni($id))) {
        $start = new DateTime($first_date);
        $end = new DateTime($future_date);
        $interval = new DateInterval('P1D');
        $period = new DatePeriod($start, $interval, $end->add($interval));
        Corsiplanning::insert_corsi_planning($period,$giorni,$corso);
    }

    $corsi_pagamenti = Select("id,scadenza,CONCAT( DATE_FORMAT( scadenza, '%Y-%m-'), LPAD({$_REQUEST['scadenza']}, 2, '0') ) as check_scadenza")
        ->from('corsi_pagamenti')
        ->where("id_corso = {$id}")
        ->get();

    foreach ($corsi_pagamenti as $key => $value) {
        if($value['scadenza']!=$value['check_scadenza']){
            Update('corsi_pagamenti')->set(['scadenza'=>$value['check_scadenza']])->where("id={$value['id']}");
        }
    }
            