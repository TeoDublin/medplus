<?php
    $_REQUEST['skip_cookie'] = true;
    require_once '../includes.php';

    $id = (int)($_REQUEST['id'] ?? 0);
    $id_colore = (int)($_REQUEST['id_colore'] ?? 0);

    $save = [
        'id_categoria' => $_REQUEST['id_categoria'] ?? '',
        'trattamento' => $_REQUEST['trattamento'] ?? '',
        'acronimo' => $_REQUEST['acronimo'] ?? '',
        'prezzo' => $_REQUEST['prezzo'] ?? 0,
        'id_colore' => $id_colore ?: '',
    ];

    if ($id_colore) {
        $where = "id_colore={$id_colore}";
        if ($id) $where .= " AND id<> {$id}";
        Update('trattamenti')->set(['id_colore' => ''])->where($where);
    }

    if ($id) {
        Update('trattamenti')->set($save)->where("id={$id}");
    }
    else {
        $id = Insert($save)->into('trattamenti')->get();
    }

    echo json_encode(['success' => true, 'id' => $id]);
