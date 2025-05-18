<?php
ob_start();
$_REQUEST['skip_cookie'] = true;
require_once '../includes.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$zipFile = sys_get_temp_dir() . '/fatture_' . time() . '.zip';
$zip = new ZipArchive;
$files=[];

$query = Session()->get('last_query');

if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
    foreach (Sql()->select($query) as $result) {
        $file=root(fatture_path($result['link']));
        if (file_exists($file)) {
            $zip->addFile($file, str_replace(' ','',"{$result['data']}-{$result['index']}-{$result['nominativo']}.pdf"));
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
$fp = fopen($zipFile, 'rb');
while (!feof($fp)) {
    echo fread($fp, 8192);
    flush();
}
fclose($fp);
unlink($zipFile);

exit;