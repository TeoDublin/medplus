<?php
    require '../includes.php';

    $pdf = new FPDF();
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
    $pdf->MultiCell(0, 6, trim($_REQUEST['date']));
    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 6);
    $pdf->MultiCell(0, 6, trim($_REQUEST['articolo']));
    $pdf->Ln();

    
    $pdf->SetY(-40);
    $pdf->MultiCell(0, 4, trim($_REQUEST['footer']),0,'C');
    
    
    $file="arquive/fatture/".datetime().'.pdf';
    $pdf->Output('F', root($file));
    echo url($file);
