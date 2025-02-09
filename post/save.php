<?php
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    $id=request('id');
    $table=request('table');
    if($id&&!empty($id))Update($table)->set($_REQUEST)->where("id={$id}");
    else $id=Insert($_REQUEST)->into($table)->get();
    echo $id;