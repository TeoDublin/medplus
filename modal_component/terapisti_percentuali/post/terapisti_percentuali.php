<?php
    header('Content-Type: application/json; charset=utf-8');

    $_REQUEST['skip_cookie'] = true;
    require_once '../../../includes.php';
    
    $id = (int) $_REQUEST['id'] ?? null;
    $terapista = $_REQUEST['terapista'];
    $profilo = $_REQUEST['profilo'];
    $trattamenti_medplus = $_REQUEST['trattamenti_medplus'] ?? 0;
    $trattamenti_isico_napoli = $_REQUEST['trattamenti_isico_napoli'] ?? 0;
    $trattamenti_isico_salerno = $_REQUEST['trattamenti_isico_salerno'] ?? 0;
    $trattamenti_dz = $_REQUEST['trattamenti_dz'] ?? 0;
    $corsi_medplus = $_REQUEST['corsi_medplus'] ?? 0;
    $corsi_isico_salerno = $_REQUEST['corsi_isico_salerno'] ?? 0;
    $corsi_isico_napoli = $_REQUEST['corsi_isico_napoli'] ?? 0;
    $corsi_dz = $_REQUEST['corsi_dz'] ?? 0;

    if(!$id){

        $id_terapista = Insert([
            'terapista' => $terapista,
            'profilo' => $profilo
        ])
        ->into('terapisti')
        ->get();
    }
    else {

        $id_terapista = $id;

        Update('terapisti')
        ->set(['profilo' => $profilo])
        ->where("id = {$id}");
    }

    if(null_or_empty($id_terapista)){

        echo json_encode([
            'success'=>false,
            'message'=>'Error saving'
        ]);
    }

    Delete()->from('terapisti_percentuali')->where("id_terapista = {$id_terapista}");

    Insert([
        'id_terapista' => $id_terapista,
        'tipo_percorso' => 'Trattamenti',
        'tipo_percentuale' => 'Medplus',
        'percentuale' => $trattamenti_medplus
    ])
    ->into('terapisti_percentuali');

    Insert([
        'id_terapista' => $id_terapista,
        'tipo_percorso' => 'Trattamenti',
        'tipo_percentuale' => 'Isico Napoli',
        'percentuale' => $trattamenti_isico_napoli
    ])
    ->into('terapisti_percentuali');

    Insert([
        'id_terapista' => $id_terapista,
        'tipo_percorso' => 'Trattamenti',
        'tipo_percentuale' => 'Isico Salerno',
        'percentuale' => $trattamenti_isico_salerno
    ])
    ->into('terapisti_percentuali');

    Insert([
        'id_terapista' => $id_terapista,
        'tipo_percorso' => 'Trattamenti',
        'tipo_percentuale' => 'Daniela Zanotti',
        'percentuale' => $trattamenti_dz
    ])
    ->into('terapisti_percentuali');

    Insert([
        'id_terapista' => $id_terapista,
        'tipo_percorso' => 'Corsi',
        'tipo_percentuale' => 'Medplus',
        'percentuale' => $corsi_medplus
    ])
    ->into('terapisti_percentuali');

    Insert([
        'id_terapista' => $id_terapista,
        'tipo_percorso' => 'Corsi',
        'tipo_percentuale' => 'Isico Napoli',
        'percentuale' => $corsi_isico_napoli
    ])
    ->into('terapisti_percentuali');

    Insert([
        'id_terapista' => $id_terapista,
        'tipo_percorso' => 'Corsi',
        'tipo_percentuale' => 'Isico Salerno',
        'percentuale' => $corsi_isico_salerno
    ])
    ->into('terapisti_percentuali');

    Insert([
        'id_terapista' => $id_terapista,
        'tipo_percorso' => 'Corsi',
        'tipo_percentuale' => 'Daniela Zanotti',
        'percentuale' => $corsi_dz
    ])
    ->into('terapisti_percentuali');

    echo json_encode([
        'success' => true
    ]);