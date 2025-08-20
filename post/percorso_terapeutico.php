<?php
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    if(!(int)($id_combo=request('id_combo'))){
        $id_combo=Insert([])->into('percorsi_combo')->get();
    }
    else Delete()->from('percorsi_combo_trattamenti')->where("id_combo={$id_combo}");

    foreach($_REQUEST['trattamenti'] as $id_trattamento){
        Insert(['id_combo'=>$id_combo,'id_trattamento'=>$id_trattamento])->into('percorsi_combo_trattamenti');
    }

    if(!(int)($id_percorso=request('id_percorso'))){
        $id_percorso=Insert([
            'id_cliente'=>$_REQUEST['id_cliente'],
            'id_combo'=>$id_combo,
            'sedute'=>$_REQUEST['sedute'],
            'prezzo_tabellare'=>$_REQUEST['prezzo_tabellare'],
            'prezzo'=>$_REQUEST['prezzo'],
            'note'=>$_REQUEST['note'],
            'realizzato_da'=>$_REQUEST['realizzato_da'],
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

    Sedute()->refresh($id_percorso);