<?php
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    $id=request('id');
    $table=request('table');
    if($id&&!empty($id))Update($table)->set($_REQUEST)->where("id={$id}");
    else $id=Insert($_REQUEST)->into($table)->get();

    if(isset($_FILES['privacy'])){
        $ext = pathinfo($_FILES['privacy']['name'], PATHINFO_EXTENSION);
        $privacyFilePath = privacy_path("privacy_{$id}.{$ext}");
        if (!is_dir(dirname($privacyFilePath))) {
            mkdir(dirname($privacyFilePath), 0777, true);
        }
        copy($_FILES['privacy']['tmp_name'],privacy_path("privacy_{$id}.{$ext}"));
        Update($table)->set(['privacy'=>"privacy_{$id}.{$ext}"])->where("id={$id}");
    }
    echo $id;