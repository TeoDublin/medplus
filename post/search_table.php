<?php
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    $select=Select('*')->from($_REQUEST['table'])->limit(14)->orderby($_REQUEST['orderby']??'id DESC');
    if($_REQUEST['search'])$select->where("{$_REQUEST['search']['key']} like '%{$_REQUEST['search']['value']}%'");
    $table=$select->get_table();
    $table->{'cols'}=$_REQUEST['cols']??array_keys(array_diff_key($table->result[0]??[],['id'=>1]));
    $table->{'actions'}=is_array($_REQUEST['actions'])?json_encode($_REQUEST['actions']):$_REQUEST['actions'];
    if($_REQUEST['search'])$table->{'search'}=$_REQUEST['search'];
    echo json_encode($table);