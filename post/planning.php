<?php 
    require '../includes.php';
    function _operation(){
        $ret=$_POST['operation'];
        unset($_POST['operation']);
        return $ret;
    }
    switch (_operation()) {
        case 'all':
            if($_POST['id']!="")$id_cliente=$_POST['id'];
            else $id_cliente=Insert([
                'nominativo'=>$_POST['nominativo'],
                'indirizzo'=>$_POST['indirizzo'],
                'cap'=>$_POST['cap'],
                'citta'=>$_POST['citta'],
                'cf'=>$_POST['cf'],
                'telefono'=>$_POST['telefono'],
                'celulare'=>$_POST['celulare'],
                'email'=>$_POST['email'],
                'tipo'=>$_POST['tipo'],
                'portato_da'=>$_POST['portato_da'],
                'data_inserimento'=>$_POST['data_inserimento'],
                'prestazioni_precedenti'=>$_POST['prestazioni_precedenti'],
                'notizie_cliniche'=>$_POST['notizie_cliniche'],
                'note_trattamento'=>$_POST['note_trattamento']
            ])->into('clienti')->get();
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
            $params=array_filter(['row'=>$_POST['row'],'data'=>$_POST['data'],'ora'=>$_POST['ora'],'id_terapista'=>$_POST['id_terapista']]);
            if($id=Planning()->first(['row'=>$_POST['row'], 'id_terapista'=>$_POST['id_terapista']])['id'])Planning()->update(array_merge($params,['id'=>$id]));
            else Planning()->insert($params);
            break;
    }
    exit();