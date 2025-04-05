<?php
// Start output buffering to prevent early output
ob_start();

// Show all errors (for debugging)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Capture fatal errors (shutdown)
function test() {
    $error = error_get_last();
    if ($error) {
        file_put_contents('php://stderr', print_r($error, true));
    }
}
register_shutdown_function('test');

// Load PhpSpreadsheet
require 'class/libraries/phpspreadsheet/vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Create spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'Hello')
      ->setCellValue('B1', 'World!')
      ->setCellValue('A2', 'PHP')
      ->setCellValue('B2', 'Excel');

$filename = 'hello_world.xlsx';

// Headers for Excel download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Send file to browser
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

// Clean any buffered output and exit
ob_end_flush();
exit;
