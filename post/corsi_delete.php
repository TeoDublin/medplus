<?php 
    require_once '../includes.php';
    $insert_at=Select('DATE_FORMAT(timestamp,"%Y-%m-%d") as insert_at')->from('corsi')->where("id={$_REQUEST['id']}")->col('insert_at');
    $now=now('Y-m-d');
    if($now==$insert_at)Delete()->from('corsi')->where("id={$_REQUEST['id']}");
    else{
        Update('corsi')->set(['deleted'=>1])->where("id={$_REQUEST['id']}");
        Delete()->from('corsi_planning')->where("id_corso={$_REQUEST['id']} AND data >= '{$now}'");
    }