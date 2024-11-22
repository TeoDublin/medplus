<?php
    require '../includes.php';
    unset($_REQUEST['skip_cookie']);
    $id=request('id');
    $table=request('table');
    if($id&&!empty($id))Update($table)->set($_REQUEST)->where("id={$id}");
    else Insert($_REQUEST)->into($table);