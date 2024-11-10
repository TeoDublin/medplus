<?php
require 'includes.php';

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

$pdf->Cell(40, 10, "Client: test");

$pdf->Output('D', 'Bill.pdf');
