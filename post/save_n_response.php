<?php
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';

    header('Content-Type: application/json; charset=utf-8');

    $id=$_REQUEST['save_data']['id'];
    $table=request('table');

    if(!null_or_empty($id)){
        Update($table)->set($_REQUEST['save_data'])->where("id={$id}");
    }
    else{
        $id=Insert($_REQUEST['save_data'])->into($table)->get();
    }
    
    $ret = $_REQUEST['load_data'];
    $id_alias = $_REQUEST['id_alias'] ?? 'id';
    $ret[$id_alias] = $id;

    echo json_encode($ret);