<?php
ob_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'class/libraries/phpspreadsheet/vendor/autoload.php'; 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'Hello')
      ->setCellValue('B1', 'World!')
      ->setCellValue('A2', 'PHP')
      ->setCellValue('B2', 'Excel');

$filename = 'hello_world.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Output Excel directly to browser
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

ob_end_flush();
exit;
