<?php
require_once __DIR__.'/../libraries/fpdf186/fpdf.php';

class PDF extends FPDF
{
    function Header()
    {
        // Header content, like logo or title
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Fattura', 0, 1, 'C');
    }

    function Footer()
    {
        // Page footer
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page '.$this->PageNo(), 0, 0, 'C');
    }

    function BillContent()
    {
        // Bill Details
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, 'Daniela Zanotti', 0, 1);
        $this->Cell(0, 10, 'Dr. in Fisioterapia', 0, 1);
        $this->Cell(0, 10, 'Specialista in Terapia Manuale', 0, 1);
        $this->Cell(0, 10, 'Fisioterapista ISICO NAPOLI', 0, 1);
        $this->Cell(0, 10, 'Iscrizione Albo Nr. 936', 0, 1);
        $this->Cell(0, 10, 'Tel 08119918966', 0, 1);
        $this->Ln(10);

        // Client Details
        $this->Cell(0, 10, 'Spett.le', 0, 1);
        $this->Cell(0, 10, 'Aprea Ettore', 0, 1);
        $this->Cell(0, 10, 'Via F. Gaelota 23', 0, 1);
        $this->Cell(0, 10, '80125 Napoli', 0, 1);
        $this->Ln(10);

        // Table Header
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(120, 10, 'OGGETTO', 1);
        $this->Cell(60, 10, 'IMPORTI', 1, 1, 'C');

        // Table Rows
        $this->SetFont('Arial', '', 12);
        $this->Cell(120, 10, 'INTERVENTI/SEDUTE DI FISIOTERAPIA:', 1);
        $this->Cell(60, 10, '€ 90,00', 1, 1, 'C');
        
        $this->Cell(120, 10, 'Bollo', 1);
        $this->Cell(60, 10, '€ 2,00', 1, 1, 'C');
        
        // Total
        $this->Cell(120, 10, 'IMPOSTA', 1);
        $this->Cell(60, 10, '€ 92,00', 1, 1, 'C');

        // Signature
        $this->Ln(20);
        $this->Cell(0, 10, '____________________', 0, 1, 'R');
        $this->Cell(0, 10, 'Dr.ssa Daniela Zanotti', 0, 1, 'R');
        $this->Cell(0, 10, 'specialista in terapia manuale', 0, 1, 'R');
    }
}