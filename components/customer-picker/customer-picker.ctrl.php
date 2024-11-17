<?php
    $split=explode('/', $_SERVER['REQUEST_URI']);$project=$_SERVER['DOCUMENT_ROOT'].'/'.$split[1];
    require "{$project}/includes.php";
    switch ($_POST['action']) {
        case 'select-nominativo':
            echo Select('*')->from('clienti')->where("nominativo like '%".str_scape($_POST['nominativo'])."%'")->json();
            break;
    }