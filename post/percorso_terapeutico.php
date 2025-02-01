<?php
    $_REQUEST['skip_cookie']=true;
    require '../includes.php';
    $tipo_trattamento = Select('tipo')->from('trattamenti')->where("id={$_REQUEST['id_trattamento']}")->col('tipo');
    switch ($tipo_trattamento) {
        case 'Mensile':
            $id_percorso=Insert([
                'id_cliente'=>$_REQUEST['id_cliente'],
                'id_trattamento'=>$_REQUEST['id_trattamento'],
                'prezzo_tabellare'=>$_REQUEST['prezzo_tabellare'],
                'prezzo'=>$_REQUEST['prezzo'],
                'scadenza'=>$_REQUEST['scadenza'],
                'note'=>$_REQUEST['note']
            ])->into('percorsi_terapeutici')->get();
            break;
        case 'Per Seduta':
            $id_percorso=Insert([
                'id_cliente'=>$_REQUEST['id_cliente'],
                'id_trattamento'=>$_REQUEST['id_trattamento'],
                'sedute'=>$_REQUEST['sedute'],
                'prezzo_tabellare'=>$_REQUEST['prezzo_tabellare'],
                'prezzo'=>$_REQUEST['prezzo'],
                'note'=>$_REQUEST['note']
            ])->into('percorsi_terapeutici')->get();
            for ($i=0; $i < $_REQUEST['sedute']; $i++) { 
                Insert([
                    'index'=>$i+1,
                    'id_cliente'=>$_REQUEST['id_cliente'],
                    'id_percorso'=>$id_percorso,
                    'id_trattamento'=>$_REQUEST['id_trattamento']
                ])->into('percorsi_terapeutici_sedute');
            }
            break;
    }
    Insert([
        'id_percorso'=>$id_percorso,
        'id_cliente'=>$_REQUEST['id_cliente'],
        'prezzo_tabellare'=>$_REQUEST['prezzo_tabellare'],
        'prezzo'=>$_REQUEST['prezzo']
    ])->into('percorsi_pendenze');
    
    