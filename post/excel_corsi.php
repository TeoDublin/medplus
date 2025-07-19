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

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$line = 1;

function _view_corsi_pagamenti_export(){
    return Select('*')->from('view_corsi_pagamenti_export')->where("`scadenza` like '{$_POST['month']}%'")->get();
}

function _isico($categoria){
    return $categoria == 'Isico';
}

function _saldo_isico($categoria,$prezzo){
    if(_isico($categoria)){
        return str_replace(',','',round(0.3 * $prezzo,2));
    }
    return 0;
}

function _saldo_terapista($categoria,$percentuale_terapista,$prezzo){
    $ret=$prezzo;
    if(_isico($categoria)){
        $ret=$ret - ( 0.3 * $ret );
    }
    $ret = $ret * ( $percentuale_terapista / 100);
    return str_replace(',','',round($ret,2));
}

foreach (_view_corsi_pagamenti_export() as $result) {
    $map=[
        'Terapista'=>$result['terapista'],
        'mese'=>$_POST['month'],
        'Cliente'=>$result['nominativo'],
        'Categoria'=>$result['categoria'],
        'Corso'=>$result['corso'],
        'Prezzo'=>str_replace(',','',$result['prezzo']),
        '% terapista'=>$result['percentuale_corsi'],
        'Saldo Isico'=>_saldo_isico($result['categoria'],$result['prezzo']),
        'Saldo Terapista'=>_saldo_terapista($result['categoria'],$result['percentuale_corsi'],$result['prezzo'])
    ];
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
            $dateValue = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(\DateTime::createFromFormat('d/m/Y', $value));
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
