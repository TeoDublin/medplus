<?php 
function test() {
  var_dump(error_get_last());
}
register_shutdown_function('test');

require_once 'includes.php';
require_once 'includes/header.php';

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
header('Content-Disposition: attachment; filename="'.$filename.'"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

exit;
