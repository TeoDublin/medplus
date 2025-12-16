<?php
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    $id=request('id');
    $files=request('files');
    $table='uscite_registrate';

    if($id&&!empty($id)){
        Update($table)->set($_REQUEST)->where("id={$id}");
    }
    else{
        $id=Insert($_REQUEST)->into($table)->get();
    }


    $saved_files = [];

    foreach( json_decode($files) as $file){
        if((int)$file->id > 0){
            $saved_files[$file->id] = $file->id;
        }
        else{
            if(!is_file($file->path)){
                throw new Exception("Error Processing Request", 1);
            }

            Insert([
                'id_uscite'=>$id,
                'filename'=>basename($file->path),
                'original_name'=>$file->filename,
                'created_at'=>$file->created_at
            ])->into('uscite_registrate_files');
        }
    }
    
    ob_clean();
    echo trim($id);