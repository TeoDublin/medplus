<?php
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    if(!($id_combo=request('id_combo'))){
        $id_combo=Insert([])->into('percorsi_combo')->get();
    }
    else Delete()->from('percorsi_combo_trattamenti')->where("id_combo={$id_combo}");

    foreach($_REQUEST['trattamenti'] as $id_trattamento){
        Insert(['id_combo'=>$id_combo,'id_trattamento'=>$id_trattamento])->into('percorsi_combo_trattamenti');
    }

    if(!($id_percorso=request('id_combo'))){
        $id_percorso=Insert([
            'id_cliente'=>$_REQUEST['id_cliente'],
            'id_combo'=>$id_combo,
            'sedute'=>$_REQUEST['sedute'],
            'prezzo_tabellare'=>$_REQUEST['prezzo_tabellare'],
            'prezzo'=>$_REQUEST['prezzo'],
            'note'=>$_REQUEST['note']
        ])->into('percorsi_terapeutici')->get();
    }
    else{
        Update('percorsi_terapeutici')->set([
            'id_cliente'=>$_REQUEST['id_cliente'],
            'id_combo'=>$id_combo,
            'sedute'=>$_REQUEST['sedute'],
            'prezzo_tabellare'=>$_REQUEST['prezzo_tabellare'],
            'prezzo'=>$_REQUEST['prezzo'],
            'note'=>$_REQUEST['note']
        ])->where("id={$id_percorso}");
    }

    function _percorsi_terapeutici_sedute($id_percorso,$id_combo,$index){
        return Select('*')
            ->from('percorsi_terapeutici_sedute')
            ->where("id_percorso={$id_percorso}")
            ->and("id_combo={$id_combo}")
            ->and("`index`={$index}")
            ->first_or_false();
    }
    for ($i=0; $i < $_REQUEST['sedute']; $i++) { 
        $index=$i+1;
        if(_percorsi_terapeutici_sedute($id_percorso,$id_combo,$index)){
            Update('percorsi_terapeutici_sedute')->set([
                'index'=>$index,
                'id_cliente'=>$_REQUEST['id_cliente'],
                'id_percorso'=>$id_percorso,
                'id_combo'=>$id_combo
            ])->where("id_percorso={$id_percorso} AND id_combo={$id_combo} AND index={$index}");
        }
        else{
            Insert([
                'index'=>$index,
                'id_cliente'=>$_REQUEST['id_cliente'],
                'id_percorso'=>$id_percorso,
                'id_combo'=>$id_combo
            ])->into('percorsi_terapeutici_sedute');
        }
    }