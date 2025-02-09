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
        $pdf->Cell(90, 10, "  {$row['oggetto']}", 'LR', 0, 'L');
        $pdf->Cell(90, 10, EURO." ".number_format($row['importo'], 2, ',', '.'), 'R', 1, 'C');
        $count++;
    }
    $rows=6;
    if($count<$rows){
        for($i=0;$i<$rows-$count;$i++){
            $pdf->Cell(90, 10, '', 'LR', 0, 'L');
            $pdf->Cell(90, 10, '', 'R', 1, 'C');
        }
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
    $pdf->Ln();

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetY(-40);
    $pdf->MultiCell(0, 4, trim($_REQUEST['footer']),0,'C');
    
    
    $file=fatture_path(($_REQUEST['filename']??datetime()).'.pdf');
    $pdf->Output('F', root($file));
    echo url($file);
