<?php
ob_start();
$_REQUEST['skip_cookie'] = true;
require_once '../includes.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require '../class/libraries/phpspreadsheet/vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$query = Session()->get('last_query');
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$line = 1;
$fatture = Fatture();

foreach (Sql()->select($query) as $result) {
    $map = $fatture->map_out($result);
    if ($line == 1) {
        $col = 'A';
        foreach ($map as $key => $value) {
            $sheet->setCellValue("{$col}{$line}", $key);
            $sheet->getStyle("{$col}{$line}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $col++;
        }
        $line = 2;
    }

    $col = 'A';
    foreach ($map as $key => $value) {
        $cell = "{$col}{$line}";
        if ($key === 'link' && !empty($value)) {
            $sheet->setCellValue($cell, $value);
            $sheet->getCell($cell)->getHyperlink()->setUrl(url(fatture_path($value)));
            $sheet->getStyle($cell)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLUE);
            $sheet->getStyle($cell)->getFont()->setUnderline(true);
        } 
        elseif (strpos($key, 'Data') !== false && !empty($value)) {
            $dateValue = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(\DateTime::createFromFormat('d/m/Y', $value));
            $sheet->setCellValue($cell, $dateValue);
            $sheet->getStyle($cell)->getNumberFormat()->setFormatCode('DD/MM/YYYY');
        } 
        else {
            $sheet->setCellValue($cell, $value);
        }
        $sheet->getStyle("{$col}{$line}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getColumnDimension($col)->setAutoSize(true);
        $col++;
    }    
    $line++;
}

$filename = 'fatture_' . time() . '.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

ob_clean();
flush();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

ob_end_flush();
exit;
