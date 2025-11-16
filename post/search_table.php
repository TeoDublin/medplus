<?php
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    $select=Select('*')->from($_REQUEST['table'])->limit(14)->orderby($_REQUEST['orderby']??'id DESC');
    if(isset($_REQUEST['search'])){
        $search_value=str_replace("'","\'",$_REQUEST['search']['value']);
        $select->where("{$_REQUEST['search']['key']} like '%{$search_value}%'");
    }
    $table=$select->get_table();
    $table->{'cols'}=$_REQUEST['cols']??array_keys(array_diff_key($table->result[0]??[],['id'=>1]));
    if(!isset($_REQUEST['actions'])){
        $table->{'actions'} = '';
    }
    else{
        $table->{'actions'}=is_array($_REQUEST['actions'])?json_encode($_REQUEST['actions']):$_REQUEST['actions'];
    }
    if(isset($_REQUEST['search'])){
        $table->{'search'}=$_REQUEST['search'];
    }
    echo json_encode($table);