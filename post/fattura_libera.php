<?php
    require '../includes.php';

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(40, 10, "TEST");
    $file="arquive/fatture/".datetime().'.pdf';
    $pdf->Output('F', root($file));
    echo url($file);
