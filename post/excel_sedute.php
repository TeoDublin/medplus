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

foreach (Sql()->select($query) as $result) {
    $map = [
        'Nominativo' => $result['nominativo'],
        'Portato Da'=> $result['portato_da'],
        'Terapista'=> $result['terapista'],
        'Trattamenti'=> $result['trattamenti'],
        'Acronimo'=> $result['acronimo'],
        'Prezzo' => $result['prezzo'],
        'Seduta' => $result['index'],
        'Stato Seduta' => $result['stato_seduta'],
        'Data Seduta' => unformat_date($result['data_seduta'],''),

        'Stato Pagamento' => $result['stato_pagamento'],
        'Valore Saldato' => $result['saldato'],
        'Data Pagamento'=> unformat_date($result['data_pagamento'],''),
        
        'Percentuale Terapista' => $result['percentuale_terapista'],
        'Saldo Terapista' => $result['saldo_terapista'],
        'Saldato Terapista' => $result['saldato_terapista'],
        'Stato Pagamento Terapista' => $result['stato_saldato_terapista'],
        'Data Pagamento al Terapista'=> unformat_date($result['data_saldato_terapista'],''),
        
    ];

    if ($line == 1) {
        $col = 'A';
        foreach ($map as $key => $value) {
            $sheet->setCellValue("{$col}{$line}", $key);
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
        $col++;
    }
    $line++;
}

$filename = 'sedute_' . time() . '.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

ob_clean();
flush();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

ob_end_flush();
exit;
