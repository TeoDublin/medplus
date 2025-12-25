<?php
if(isset($_REQUEST['isJS'])){
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    $id = 0;
    $path = $_FILES['files']['tmp_name'][0];
    $original_name = $_FILES['files']['name'][0];
    
    $created_at = now('Y-m-d H:i:s');

    $unique_name = unique_name(uscite_path($original_name));
    move_uploaded_file($path, $unique_name);
    $path = $unique_name;
    $path_relative = str_replace(project_path(),"/".PROJECT_NAME,$path);
}

$original_name_text = substr($original_name, 0, 40);
$created_at_text = unformat_datetime($created_at);

echo "<div class=\"col-auto d-flex\" >
    <div class=\"card h-100 div-files\" style=\"width:170px\" 
        onmouseenter=\"window.modalHandlers['add_uscita'].viewFileEnter(this)\" 
        onClick=\"window.modalHandlers['add_uscita'].viewFileClick(this)\" 
        data-id=\"{$id}\"
        data-path=\"{$path}\"
        data-path_relative=\"{$path_relative}\"
        data-filename=\"{$original_name}\"
        data-created_at=\"{$created_at}\"
        >
        <div class=\"card-header\">
            <div class=\"py-2 ms-1 mt-auto ms-auto\" 
                style=\"max-width:50px!important\"
                >
                <button 
                    class=\"btn btn-dark w-100 btnDel\" 
                    onmouseenter=\"window.modalHandlers['add_uscita'].delFileEnter(this)\"
                    onmouseleave=\"window.modalHandlers['add_uscita'].delFileLeave(this)\"
                    >
                    ".icon('bin.svg','white')."
                </button>
            </div>
        </div>
        <div class=\"card-body\">
            <h6 class=\"card-title\">{$original_name_text}</h6>
            <p class=\"card-text\">{$created_at_text}</p>
        </div>
    </div>
</div>";