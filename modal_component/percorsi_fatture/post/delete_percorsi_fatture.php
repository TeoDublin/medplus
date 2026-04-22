<?php 

    require_once '../../../includes.php';

    try {

        $delete = new PagamentiChildDelete($_REQUEST);
        $delete->delete();

        echo json_encode([
            'success' => true,
            'message' => 'Pagamento eliminato correttamente'
        ]);
    } catch (Throwable $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
    