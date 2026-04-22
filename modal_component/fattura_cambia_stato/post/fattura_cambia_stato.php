<?php

    $_REQUEST['skip_cookie']=true;
    require_once '../../../includes.php';
    header('Content-Type: application/json; charset=utf-8');

   $payload = [
        'id' => $_REQUEST['id'],
        'stato_pagamento' => $_REQUEST['stato'],
        'data_pagamento' => $_REQUEST['data'],
    ];

    try {
        $obj = new PagamentiChildCambiaStato($payload);
        $obj->save();
    } catch (\Throwable $th) {
        echo json_encode([
            'success' => false,
            'message' => $th->getMessage()
        ]);
        exit();
    }

    echo json_encode([
        'success' => true,
    ]);