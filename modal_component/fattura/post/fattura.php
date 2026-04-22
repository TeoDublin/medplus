<?php
    require_once '../../../includes.php';

    function _cliente($id_cliente){
        return Select("
            *,
            CONCAT('Spett.le ',COALESCE(fattura_nominativo,nominativo)) AS name,
            indirizzo,
            CONCAT(cap,' ',citta) AS cap,
            CONCAT('CF o P.Iva ',COALESCE(fattura_cf,cf)) AS cf
        ")
        ->from('clienti')
        ->where("id = {$id_cliente}")
        ->first();
    }

    function _stato_pagamento($percorsi_terapeutici_sedute,$importo){

        if($metodo_pagamento=='Bonifico'){
            return 'Fatturato';
        }
        elseif($importo < $percorsi_terapeutici_sedute){
            return 'Parziale';
        }

        return 'Saldato';
    }

    $id_cliente = $_REQUEST['payload']['data_cliente']['id'];
    $data_creazione = $_REQUEST['data_creazione'];
    $index = $_REQUEST['index'];
    $metodo_pagamento = $_REQUEST['metodo_pagamento'];
    $oggetti = $_REQUEST['oggetti'];
    $totale = (double) $_REQUEST['totale'];
    $inps = (double) $_REQUEST['inps'] ?? 0;
    $bollo = (double) $_REQUEST['bollo'] ?? 0;
    $subtotale = $totale - $inps - $bollo;
    $width = 0;
    $dati = [];
    $rows = 2;
    $get_data = ['name','indirizzo','cap','cf'];
    $cliente = _cliente($id_cliente);
    $link = str_replace([' ',':'],'_',$cliente['nominativo'].'_'.datetime().'.pdf');
    $file = fatture_path($link);
    $stato = $metodo_pagamento =='Bonifico'?'Pendente':'Saldato';
    
    $pdf = new FPDF();
    
    define('EURO',chr(128));
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->MultiCell(0, 6, "Daniela Zanotti Dr. in Fisioterapia");
    $pdf->MultiCell(0, 6, "Specialista in Terapia Manuale");
    $pdf->MultiCell(0, 6, "Fisioterapista ISICO NAPOLI");
    $pdf->MultiCell(0, 6, "Iscrizione Albo Nr.909");
    $pdf->MultiCell(0, 6, "Tel 08119918966");
    $pdf->MultiCell(0, 6, "Iban: IT82M0301503200000002984154");
    $pdf->Ln();

    foreach ($cliente as $key=> $value) {
        if(in_array($key,$get_data)){
            $current=$pdf->GetStringWidth($value);
            $width = $current>$width?$current:$width;
            $dati[array_flip($get_data)[$key]]=$value;
        }
    }

    ksort($dati);
    $pdf->SetX($pdf->GetPageWidth() - $width - 20);
    $pdf->MultiCell($width +10, 6,iconv('UTF-8', 'windows-1252',implode("\r\n",$dati)), 0, 'C');
    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->MultiCell(0, 6, "Fattura n: {$index} del: ".unformat_date($data_creazione));
    $pdf->Ln();

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(90, 12, 'OGGETTO', 1, 0, 'C');
    $pdf->Cell(90, 12, 'IMPORTI', 1, 1, 'C');

    $count=0;
    $pdf->SetFont('Arial', '', 12);

    foreach($oggetti ?? [] as $row){

        if ($pdf->GetY() + 10 > $pdf->GetPageHeight() - 10) {
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(90, 12, 'OGGETTO', 1, 0, 'C');
            $pdf->Cell(90, 12, 'IMPORTI', 1, 1, 'C');
            $pdf->SetFont('Arial', '', 12);
        }

        $importo=$row['importo']==''?'':EURO." ".number_format($row['importo'], 2, ',', '.');

        $pdf->Cell(90, 10, "  {$row['oggetto']}", 'LR', 0, 'L');
        $pdf->Cell(90, 10, $importo, 'R', 1, 'C');
        $count++;
    }

    if( $count < $rows){
        for($i=0;$i<$rows-$count;$i++){
            $pdf->Cell(90, 10, '', 'LR', 0, 'L');
            $pdf->Cell(90, 10, '', 'R', 1, 'C');
        }
    }

    if( $inps > 0){
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(90, 12, '  Rivalsa INPS (4%)', 'LR', 0, 'L');
        $pdf->Cell(90, 12, EURO." ".number_format( $inps, 2, ',', '.'), 'R', 1, 'C');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(90, 12, '  Subtotale', 'LR', 0, 'L');
        $pdf->Cell(90, 12, EURO." ".number_format( $subtotale, 2, ',', '.'), 'R', 1, 'C');
    }

    if($bollo > 0){
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(90, 12, '  Bollo', 'LR', 0, 'L');
        $pdf->Cell(90, 12, EURO." ".number_format( $bollo, 2, ',', '.'), 'R', 1, 'C');
    }

    $pdf->Cell(90, 12, '  TOTALE FATTURA', 1, 0, 'L');
    $pdf->Cell(90, 12, EURO." ".number_format($totale, 2, ',', '.'), 1, 1, 'C');

    $pdf->SetFont('Arial', 'I', 8);
    $pdf->Cell(180, 10, iconv('UTF-8', 'windows-1252', "Marca da bollo su originale di € 2,00 per importi superiori ad € 77,47"), 1, 0, 'L');

    $pdf->Ln();
    $pdf->MultiCell(0, 10, "Operazione esente da Iva effettuata ai sensi dell'art. 10, DPR 633/72");
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->MultiCell(0, 10, trim("Metodo di Pagamento: {$metodo_pagamento}"));
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetY(-40);
    $pdf->MultiCell(0, 4, 'P.IVA: 06191421210',0,'C');
    $pdf->MultiCell(0, 4, 'C.F.ZNT DNL 64P58 F839W',0,'C');
    $pdf->MultiCell(0, 4, 'VIA LEOPARDI N.253',0,'C');
    $pdf->MultiCell(0, 4, '80125 NAPOLI',0,'C');

    $id_fattura = Insert([
        'id_cliente' => $id_cliente,
        'link' => $link,
        'index' => $index ,
    ])->into('fatture')->get();

    $payload = [
        'valore' => $subtotale,
        'inps' => $inps,
        'bollo' => $bollo,
        'id_cliente' => $id_cliente,
        'tipo_pagamento' => 'Fattura D.Z.',
        'metodo' => $metodo_pagamento,
        'percorsi' => $_REQUEST['payload']['percorsi'] ?? [],
        'data_creazione' => $data_creazione,
        'note' => '',
        'fattura_aruba' => null,
        'id_fattura' => $id_fattura,
    ];

    $obj = new PagamentiChild($payload);
    $obj->save();
    
    $pdf->Output('F', root( $file ));
    echo fatture_path( $link );