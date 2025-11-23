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

function _map():array{
    return [
        'id'=>['col'=>'id'],
        'Nominativo'=>['col'=>'nominativo'],
        'Origine'=>['col'=>'origine'],
        'Metodo'=>['col'=>'metodo'],
        'Data'=>['col'=>'data','type'=>'date'],
        'Imponibile'=>['col'=>'imponibile','type'=>'double'],
        'Inps'=>['col'=>'inps','type'=>'double'],
        'Bollo'=>['col'=>'bollo','type'=>'double'],
        'Totale'=>['col'=>'totale','type'=>'double'],
        'Note'=>['col'=>'note'],
        'Stato'=>['col'=>'stato'],
        'Voucher'=>['col'=>'bnw'],
    ];
}

function _map_out($data):array{
    $ret=[];
    foreach(_map() as $key=>$value){
        $ret[$key]=$data[$value['col']];
    }
    return $ret;
}

foreach (Sql()->select($query) as $result) {

    $map = _map_out($result);

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
        $sheet->setCellValue("{$col}{$line}", $value);
        if (strpos($key, 'Data') !== false && !empty($value)) {
            $dateValue = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(\DateTime::createFromFormat('d/m/Y', unformat_date($value)));
            $sheet->setCellValue("{$col}{$line}", $dateValue);
            $sheet->getStyle("{$col}{$line}")->getNumberFormat()->setFormatCode('DD/MM/YYYY');
        }
        $sheet->getStyle("{$col}{$line}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getColumnDimension($col)->setAutoSize(true);
        $col++;
    }
    $line++;
}

$filename = 'incassi_' . time() . '.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

ob_clean();
flush();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

ob_end_flush();
exit;
