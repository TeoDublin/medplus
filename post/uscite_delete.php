<?php 
    require_once '../includes.php';
    $files = Select('*')->from('uscite_registrate_files')->where("id_uscite={$_REQUEST['id']}")->get();
    foreach ($files as $file) {
        $path = uscite_path($file['filename']);
        if(is_file($path)){
            unlink($path);
        }
        Delete()->from('uscite_registrate_files')->where("id={$file['id']}");
    }
    Delete()->from($_REQUEST['table'])->where("id={$_REQUEST['id']}");