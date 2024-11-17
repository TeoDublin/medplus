<?php 
    require '../includes.php';
    switch (request('operation')) {
        case 'all':
            $params=[
                'nominativo'=>str_scape($_POST['nominativo']),
                'indirizzo'=>$_POST['indirizzo'],
                'cap'=>$_POST['cap'],
                'citta'=>$_POST['citta'],
                'cf'=>$_POST['cf'],
                'telefono'=>$_POST['telefono'],
                'cellulare'=>$_POST['cellulare'],
                'email'=>$_POST['email'],
                'tipo'=>$_POST['tipo'],
                'portato_da'=>$_POST['portato_da'],
                'data_inserimento'=>$_POST['data_inserimento'],
                'prestazioni_precedenti'=>$_POST['prestazioni_precedenti'],
                'notizie_cliniche'=>$_POST['notizie_cliniche'],
                'note_trattamento'=>$_POST['note_trattamento']
            ];
            if($_POST['id']!=""){
                $id_cliente=$_POST['id'];
                Update('clienti')->set($params)->where("id={$id_cliente}");
            }
            else $id_cliente=Insert($params)->into('clienti')->get();
            $params=[
                'row'=>$_POST['row'],
                'data'=>$_POST['data'],
                'ora'=>$_POST['ora'],
                'note'=>$_POST['note'],
                'id_terapista'=>$_POST['id_terapista'],
                'id_cliente'=>$id_cliente,
                'id_trattamento'=>$_POST['id_trattamento'],
                'sedute'=>$_POST['sedute'],
                'prezzo'=>$_POST['prezzo']
            ];
            if($id=Select('p.*')->from('planning','p')
                ->where("p.row={$_POST['row']}")
                ->and("p.data='".format_date($_POST['data'])."'")
                ->and("p.id_terapista = {$_POST['id_terapista']}")
                ->col('id')
            )Update('planning')->set($params)->where("id={$id}");
            else Insert($params)->into('planning');
            break;
        case 'hour':
        case 'note':
            $_REQUEST['data']=format_date($_REQUEST['data']);
            $id=Select('p.id')
                ->from('planning','p')
                ->where("`row`={$_REQUEST['row']} and `data`='{$_REQUEST['data']}' and `id_terapista`={$_REQUEST['id_terapista']}")
                ->col('id');
            if($id)Update('planning')->set($_REQUEST)->where("id={$id}");
            else Insert($_REQUEST)->into('planning');
            break;
        case 'clean_hour':
            $_REQUEST['data']=format_date($_REQUEST['data']);
            $planning=Select('p.*')
                ->from('planning','p')
                ->where("`row`={$_REQUEST['row']} and `data`='{$_REQUEST['data']}' and `id_terapista`={$_REQUEST['id_terapista']}")
                ->first();
            if($planning['note']||$planning['id_cliente']||$planning['id_trattamento']||$planning['sedute']||$planning['prezzo'])Update('planning')->set($_REQUEST)->where("id={$planning['id']}");
            else Delete($planning['id'])->from('planning');
            break;
        case 'clean_note':
            $_REQUEST['data']=format_date($_REQUEST['data']);
            $planning=Select('p.*')
                ->from('planning','p')
                ->where("`row`={$_REQUEST['row']} and `data`='{$_REQUEST['data']}' and `id_terapista`={$_REQUEST['id_terapista']}")
                ->first();
            if($planning['ora']||$planning['id_cliente']||$planning['id_trattamento']||$planning['sedute']||$planning['prezzo'])Update('planning')->set($_REQUEST)->where("id={$planning['id']}");
            else Delete($planning['id'])->from('planning');
            break;
    }