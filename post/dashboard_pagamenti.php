<?php
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';

    function _month($key,$value){
        if(isset($value[$key])){
            return $value[$key];
        }
        return 0;
    }

    function _obj($obj){
        return [
            0=>_month('01',$obj),
            1=>_month('02',$obj),
            2=>_month('03',$obj),
            3=>_month('04',$obj),
            4=>_month('05',$obj),
            5=>_month('06',$obj),
            6=>_month('07',$obj),
            7=>_month('08',$obj),
            8=>_month('09',$obj),
            9=>_month('10',$obj),
            10=>_month('11',$obj),
            11=>_month('12',$obj)
        ];
    }

    $map=$ret=[];

    $view_dashboard_pagamenti = Select('*')->from('view_dashboard_pagamenti')->where("anno={$_REQUEST['year']}")->get();
    foreach($view_dashboard_pagamenti as $vdp){
        $map[$vdp['metodo']][$vdp['mese']]=$vdp['importo'];
    }

    foreach($map as $metodo=>$obj){
        $ret[$metodo]=_obj($obj);
    }

    echo json_encode($ret); 