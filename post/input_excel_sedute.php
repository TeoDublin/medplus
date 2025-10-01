<?php
$_REQUEST['skip_cookie'] = true;
require_once '../includes.php';
require '../class/libraries/phpspreadsheet/vendor/autoload.php'; 
use PhpOffice\PhpSpreadsheet\IOFactory;
$sedute = Sedute();
$errors=[];
if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $dir = 'arquive/sedute_in/'.now('Y-m-d').'/';
    mkdir( $dir, 0777, true );
    $tmpPath = $_FILES['file']['tmp_name'];
    move_uploaded_file( $tmpPath, $dir.basename($_FILES['file']['name']) );
    $spreadsheet = IOFactory::load($tmpPath);
    $sheet = $spreadsheet->getActiveSheet();
    $data = $sheet->toArray();
    $erros=$headers=[];
    foreach ($data as $row) {
        if(count($headers)==0)$headers=$row;
        else{
            $map=$sedute->map_in(array_combine($headers,$row));
            if($map['has_error'])$errors[]=$map;
            elseif(isset($map['id']))Update('percorsi_terapeutici_sedute')->set($map)->where("id={$map['id']}");
        }
    }
    if(count($errors)>0){
        header('Content-Type: application/json');
        http_response_code(422);
        echo json_encode(['error' => true, 'response' => $errors]);
    }
    else echo json_encode(['success' => true]);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'File upload failed.']);
}