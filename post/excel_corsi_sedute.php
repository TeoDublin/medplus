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

function _map_out($result){
    $map =  [
        'id'=>['col'=>'id'],
        'id_pagamenti'=>['col'=>'id_pagamenti'],
        'Nominativo'=>['col'=>'nominativo','type'=>'dont_save'],
        'Terapista'=>['col'=>'terapista','type'=>'dont_save'],
        'Corso'=>['col'=>'corso','type'=>'dont_save'],
        'Prezzo'=>['col'=>'prezzo','type'=>'dont_save'],
        'Scadenza'=>['col'=>'scadenza','type'=>'dont_save'],
        'Stato Pagamento'=>['col'=>'stato_pagamento','type'=>'dont_save'],
        'Valore Saldato'=>['col'=>'saldato','type'=>'dont_save'],
        'Data Pagamento'=>['col'=>'data_pagamento','type'=>'dont_save'],
        'Realizzato da'=>['col'=>'realizzato_da','type'=>'dont_save'],
        'Voucher'=>['col'=>'bnw','type'=>'dont_save']
    ];

    $ret=[];
    foreach($map as $key=>$value){
        $ret[$key]=$result[$value['col']];
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

$filename = 'corsi_' . time() . '.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

ob_clean();
flush();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

ob_end_flush();
exit;
