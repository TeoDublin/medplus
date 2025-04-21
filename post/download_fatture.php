<?php
ob_start();
$_REQUEST['skip_cookie'] = true;
require_once '../includes.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$zipFile = 'fatture_' . time() . '.zip';
$zip = new ZipArchive;
$files=[];

$query = Session()->get('last_query');

if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
    foreach (Sql()->select($query) as $result) {
        $file=fatture_path($result['link']);
        if (file_exists($file)) {
            $zip->addFile($file, basename($file));
        }
    }
    $zip->close();
}

header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . basename($zipFile) . '"');
header('Content-Length: ' . filesize($zipFile));
header('Cache-Control: max-age=0');

ob_clean();
flush();
readfile($zipFile);
unlink($zipFile);
ob_end_flush();
exit;