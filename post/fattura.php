<?php
    require_once '../includes.php';
    function _cliente(){
        return Select("
            *,
            CONCAT('Spett.le ',nominativo) AS name,
            indirizzo,
            CONCAT(cap,' ',citta) AS cap,
            CONCAT('CF o P.Iva ',cf) AS cf
        ")
        ->from('clienti')
        ->where("id = {$_REQUEST['id_cliente']}")
        ->first();
    }
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
    $width=0;
    $dati=[];
    $cliente=_cliente();
    foreach ($cliente as $key=> $value) {
        if(in_array($key,['name','indirizzo','cap','cf'])){
            $current=$pdf->GetStringWidth($value);
            $width = $current>$width?$current:$width;
            $dati[]=$value;
        }
    }
    $pdf->SetX($pdf->GetPageWidth() - $width - 20);
    $pdf->MultiCell($width +10, 6,implode("\r\n",$dati) , 0, 'C');
    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->MultiCell(0, 6, "Fattura n: {$_REQUEST['index']} del: ".unformat_date($_REQUEST['data_pagamento']));
    $pdf->Ln();

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(90, 12, 'OGGETTO', 1, 0, 'C');
    $pdf->Cell(90, 12, 'IMPORTI', 1, 1, 'C');

    $count=0;
    $pdf->SetFont('Arial', '', 12);
    foreach($_REQUEST['table'] ?? [] as $row){
        if($row['importo']=='')$row['importo']=0;

        if ($pdf->GetY() + 10 > $pdf->GetPageHeight() - 10) {
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(90, 12, 'OGGETTO', 1, 0, 'C');
            $pdf->Cell(90, 12, 'IMPORTI', 1, 1, 'C');
            $pdf->SetFont('Arial', '', 12);
        }

        $pdf->Cell(90, 10, "  {$row['oggetto']}", 'LR', 0, 'L');
        $pdf->Cell(90, 10, ($row['importo']==0?'':EURO." ".number_format($row['importo'], 2, ',', '.')), 'R', 1, 'C');
        $count++;
    }

    $rows=2;
    if($count<$rows){
        for($i=0;$i<$rows-$count;$i++){
            $pdf->Cell(90, 10, '', 'LR', 0, 'L');
            $pdf->Cell(90, 10, '', 'R', 1, 'C');
        }
    }
    if((double)$_REQUEST['inps']>0){
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(90, 12, '  Rivalsa INPS', 'LR', 0, 'L');
        $pdf->Cell(90, 12, EURO." ".number_format($_REQUEST['inps'], 2, ',', '.'), 'R', 1, 'C');
    }
    if((double)$_REQUEST['bollo']>0){
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(90, 12, '  Bollo', 'LR', 0, 'L');
        $pdf->Cell(90, 12, EURO." ".number_format($_REQUEST['bollo'], 2, ',', '.'), 'R', 1, 'C');
    }

    $pdf->Cell(90, 12, '  TOTALE FATTURA', 1, 0, 'L');
    $pdf->Cell(90, 12, EURO." ".number_format($_REQUEST['sum'], 2, ',', '.'), 1, 1, 'C');

    $pdf->SetFont('Arial', 'I', 8);
    $pdf->Cell(180, 10, iconv('UTF-8', 'windows-1252', "Marca da bollo su originale di € 2,00 per importi superiori ad € 77,47"), 1, 0, 'L');

    $pdf->Ln();
    $pdf->MultiCell(0, 10, "Operazione esente da Iva effettuata ai sensi dell'art. 10, DPR 633/72");
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->MultiCell(0, 10, trim("Metodo di Pagamento: {$_REQUEST['metodo_pagamento']}"));
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetY(-40);
    $pdf->MultiCell(0, 4, 'P.IVA: 06191421210',0,'C');
    $pdf->MultiCell(0, 4, 'C.F.ZNT DNL 64P58 F839W',0,'C');
    $pdf->MultiCell(0, 4, 'VIA LEOPARDI N.253',0,'C');
    $pdf->MultiCell(0, 4, '80125 NAPOLI',0,'C');

    $link=str_replace([' ',':'],'_',$cliente['nominativo'].'_'.datetime().'.pdf');
    $stato=$_REQUEST['metodo_pagamento']=='Bonifico'?'Pendente':'Saldata';
    $save=[
        'id_cliente'=>$_REQUEST['id_cliente'],
        'link'=>$link,
        'importo'=>$_REQUEST['importo'],
        'bollo'=>$_REQUEST['bollo'],
        'inps'=>$_REQUEST['inps'],
        'index'=>$_REQUEST['index'],
        'data'=>now('Y-m-d'),
        'metodo'=>$_REQUEST['metodo_pagamento'],
        'stato'=>$stato,
        'fatturato_da'=>$_REQUEST['is_isico']=='true'?'Isico':'Medplus'
    ];
    if(isset($_REQUEST['id_fattura'])){
        $id_fattura=$_REQUEST['id_fattura'];
        Update('fatture')->set($save)->where("id={$id_fattura}");
        Delete()->from('pagamenti_fatture')->where("id_fattura={$id_fattura}");
        Delete()->from('fatture_table')->where("id_fattura={$id_fattura}");
    }
    else{
        $id_fattura=Insert($save)->into('fatture')->get();
    }

    foreach($_REQUEST['table'] ?? [] as $row){
        Insert(['id_fattura'=>$id_fattura, 'oggetto'=>$row['oggetto'],'importo'=>$row['importo']])->into('fatture_table');
    }

    $totale=(double)$_REQUEST['importo'];
    foreach($_REQUEST['oggetti'] as $obj){
        $importo=$totale>=(double)$obj['importo']?$obj['importo']:$totale;
        $totale-=$importo;
        Insert([
            'origine'=>$obj['origine'],
            'id_origine'=>$obj['id_percorso'],
            'id_cliente'=>$_REQUEST['id_cliente'],
            'id_fattura'=>$id_fattura,
            'importo'=>$importo
        ])->into('pagamenti_fatture');
	if($obj['origine']!='corsi')Sedute()->refresh($obj['id_percorso'],$_REQUEST['data_pagamento'],'Fattura');
        if($totale<=0)break;
    }
    $file=fatture_path($link);
    $pdf->Output('F', root($file));
    echo fatture_path($link);