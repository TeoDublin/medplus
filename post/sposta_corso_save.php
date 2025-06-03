<?php
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    Delete()->from('corsi_planning_spostati')->where("id_corsi_planning={$_REQUEST['id']}");
    Insert([
        'id_corsi_planning'=>$_REQUEST['id'],
        'row_inizio'=>$_REQUEST['row_inizio'],
        'row_fine'=>$_REQUEST['row_fine'],
        'data'=>$_REQUEST['data']
    ])->into('corsi_planning_spostati');