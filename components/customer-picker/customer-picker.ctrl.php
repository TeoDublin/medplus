<?php
    $split=explode('/', $_SERVER['REQUEST_URI']);$project=$_SERVER['DOCUMENT_ROOT'].'/'.$split[1];
    require "{$project}/includes.php";
    switch ($_POST['action']) {
        case 'select-nominativo':
            echo json_encode(Clienti()->select(['nominativo'=>['like'=>"%{$_POST['nominativo']}%"]]));
            break;
    }