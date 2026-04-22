<?php

    $_REQUEST['skip_cookie']=true;

    require_once '../../../includes.php';

   $payload = [
        'valore' => (double) ($_REQUEST['valore'] ?? 0),
        'inps' => (double) ($_REQUEST['inps'] ?? 0),
        'bollo' => (double) ($_REQUEST['bollo'] ?? 0),
        'id_cliente' => $_REQUEST['payload']['id_cliente'] ?? null,
        'tipo_pagamento' => $_REQUEST['payload']['tipo_pagamento'] ?? null,
        'metodo' => $_REQUEST['metodo'] ?? null,
        'percorsi' => $_REQUEST['payload']['_data'] ?? [],
        'data_creazione' => $_REQUEST['data'] ?? null,
        'note' => $_REQUEST['note'] ?? null,
        'fattura_aruba' => $_REQUEST['fattura_aruba'] ?? null,
        'id_fattura' => $_REQUEST['id_fattura'] ?? null,
    ];

    try {
        $obj = new PagamentiChild($payload);
        $obj->save();
    } catch (\Throwable $th) {
        var_dump($th);
        throw new Exception("Error Processing Request", 1);
    }
