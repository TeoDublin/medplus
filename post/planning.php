<?php 
    require '../includes.php';
    function _select_planning(){
        return Select('p.*')
            ->from('planning','p')
            ->where("p.row={$_POST['row']}")
            ->and("p.data='".format_date($_POST['data'])."'")
            ->and("p.id_terapista = {$_POST['id_terapista']}")
            ->col('id');
    }
    switch (request('operation')) {
        case 'all':
            switch($tab=request('tab')){
                case 'anagrafica':
                    $cliente=[
                        'nominativo'=>$_POST['nominativo'],
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
                    switch ($_POST['tabella_riferimento']) {
                        case 'clienti':
                            if($_POST['id_riferimento']!=""){
                                $id_riferimento=$_POST['id_riferimento'];
                                Update('clienti')->set($cliente)->where("id={$id_riferimento}");
                            }
                            else $id_riferimento=Insert($cliente)->into('clienti')->get();
                            break;
                        default:
                            $id_riferimento=$_POST['id_riferimento'];
                            break;
                    }                    
                    $planning=[
                        'row'=>$_POST['row'],
                        'data'=>$_POST['data'],
                        'id_terapista'=>$_POST['id_terapista'],
                        'id_trattamento'=>$_POST['id_trattamento'],
                        'sedute'=>$_POST['sedute'],
                        'prezzo'=>$_POST['prezzo'],
                        'id_riferimento'=>$id_riferimento,
                        'tabella_riferimento'=>$_POST['tabella_riferimento'],
                    ];
                    if($id=_select_planning())Update('planning')->set($planning)->where("id={$id}");
                    else Insert($planning)->into('planning');
                    break;
                case 'fatture':
                    break;
                case 'trattamenti':
                    break;
                case 'sbarra':
                    break;
            }
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
            if($planning['note']||$planning['id_riferimento']||$planning['id_trattamento']||$planning['sedute']||$planning['prezzo'])Update('planning')->set($_REQUEST)->where("id={$planning['id']}");
            else Delete($planning['id'])->from('planning');
            break;
        case 'clean_note':
            $_REQUEST['data']=format_date($_REQUEST['data']);
            $planning=Select('p.*')
                ->from('planning','p')
                ->where("`row`={$_REQUEST['row']} and `data`='{$_REQUEST['data']}' and `id_terapista`={$_REQUEST['id_terapista']}")
                ->first();
            if($planning['ora']||$planning['id_riferimento']||$planning['id_trattamento']||$planning['sedute']||$planning['prezzo'])Update('planning')->set($_REQUEST)->where("id={$planning['id']}");
            else Delete($planning['id'])->from('planning');
            break;
    }