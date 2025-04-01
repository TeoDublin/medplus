<?php
    require_once '../includes.php';
    $pdf = new FPDF();
    define('EURO',chr(128));
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->MultiCell(0, 6, trim($_REQUEST['head']));
    $pdf->Ln();
    $width=0;
    foreach (explode("\n",trim($_REQUEST['dati'])) as $value) {
        $current=$pdf->GetStringWidth($value);
        $width = $current>$width?$current:$width;
    }
    $pdf->SetX($pdf->GetPageWidth() - $width - 20);
    $pdf->MultiCell($width +10, 6, trim($_REQUEST['dati']), 0, 'C');
    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->MultiCell(0, 6, trim($_REQUEST['data']));
    $pdf->Ln();

    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(90, 12, 'OGGETTO', 1, 0, 'C');
    $pdf->Cell(90, 12, 'IMPORTI', 1, 1, 'C');

    $count=0;
    $pdf->SetFont('Arial', '', 14);
    foreach($_REQUEST['table'] ?? [] as $row){
        if($row['importo']=='')$row['importo']=0;
        
        if ($pdf->GetY() + 10 > $pdf->GetPageHeight() - 10) {
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(90, 12, 'OGGETTO', 1, 0, 'C');
            $pdf->Cell(90, 12, 'IMPORTI', 1, 1, 'C');
            $pdf->SetFont('Arial', '', 14);
        }
    
        $pdf->Cell(90, 10, "  {$row['oggetto']}", 'LR', 0, 'L');
        $pdf->Cell(90, 10, EURO." ".number_format($row['importo'], 2, ',', '.'), 'R', 1, 'C');
        $count++;
    }
    
    $rows=2;
    if($count<$rows){
        for($i=0;$i<$rows-$count;$i++){
            $pdf->Cell(90, 10, '', 'LR', 0, 'L');
            $pdf->Cell(90, 10, '', 'R', 1, 'C');
        }
    }
    if($_REQUEST['bollo']){
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(90, 12, '  Bollo', 'LR', 0, 'L');
        $pdf->Cell(90, 12, EURO." ".number_format($_REQUEST['bollo'], 2, ',', '.'), 'R', 1, 'C');
    
    }
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(90, 12, '  IMPONIBILE', 'LR', 0, 'L');
    $pdf->Cell(90, 12, EURO." ".number_format($_REQUEST['imponibile'], 2, ',', '.'), 'R', 1, 'C');

    $pdf->Cell(90, 12, '  TOTALE FATTURA', 1, 0, 'L');
    $pdf->Cell(90, 12, EURO." ".number_format($_REQUEST['totale'], 2, ',', '.'), 1, 1, 'C');

    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(180, 10, " ".iconv('UTF-8', 'windows-1252',$_REQUEST['spanBollo']), 1, 0, 'L');

    $pdf->Ln();
    $pdf->MultiCell(0, 10, trim($_REQUEST['articolo']));
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->MultiCell(0, 10, trim("Metodo di Pagamento: {$_REQUEST['metodo_pagamento']}"));
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetY(-40);
    $pdf->MultiCell(0, 4, trim($_REQUEST['footer']),0,'C');
    
    $id_cliente=$_REQUEST['oggetti']['id_cliente'];
    $cliente=Select('*')->from('clienti')->where("id={$id_cliente}")->first();
    $link=str_replace([' ',':'],'_',$cliente['nominativo'].'_'.datetime().'.pdf');
    $stato=$_REQUEST['metodo_pagamento']=='Bonifico'?'Pendente':'Saldata';
    $id_fattura=Insert([
        'id_cliente'=>$id_cliente,
        'link'=>$link,
        'importo'=>$_REQUEST['totale'],
        'index'=>$_REQUEST['oggetti']['index'],
        'data'=>now('Y-m-d'),
        'metodo'=>$_REQUEST['metodo_pagamento'],
        'stato'=>$stato
    ])->into('fatture')->get();
    $totale=(int)$_REQUEST['totale'];
    $totale-=(int)$_REQUEST['bollo']??0;
    foreach($_REQUEST['oggetti']['obj'] as $obj){
        $importo=$totale>=(int)$obj['importo']?$obj['importo']:$totale;
        $totale-=$importo;
        Insert([
            'origine'=>$obj['origine'],
            'id_origine'=>$obj['id_percorso'],
            'id_cliente'=>$id_cliente,
            'id_fattura'=>$id_fattura,
            'importo'=>$importo
        ])->into('pagamenti_fatture');
        Sedute()->refresh($obj['id_percorso']);
        if($totale<=0)break;
    }
    $file=fatture_path($link);
    $pdf->Output('F', root($file));
    echo fatture_path($link);