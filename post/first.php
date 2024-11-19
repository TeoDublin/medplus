<?php 
    require '../includes.php';
    unset($_REQUEST['skip_cookie']);
    $select=Select($_POST['select'])->from($_POST['table']??$_POST['from']);
    if($_POST['where'])$select->where($_POST['where']);
    echo json_encode($select->first());