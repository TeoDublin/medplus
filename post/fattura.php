<?php
    require_once '../includes.php';
    function _cliente(){
        return Select("
            *,
            CONCAT('Spett.le ',COALESCE(fattura_nominativo,nominativo)) AS name,
            indirizzo,
            CONCAT(cap,' ',citta) AS cap,
            CONCAT('CF o P.Iva ',COALESCE(fattura_cf,cf)) AS cf
        ")
        ->from('clienti')
        ->where("id = {$_REQUEST['id_cliente']}")
        ->first();
    }

    function _stato_pagamento($percorsi_terapeutici_sedute,$importo){

        if($_REQUEST['metodo_pagamento']=='Bonifico'){
            return 'Fatturato';
        }
        elseif($importo < $percorsi_terapeutici_sedute){
            return 'Parziale';
        }

        return 'Saldato';
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
    $get_data=['name','indirizzo','cap','cf'];
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
    $pdf->MultiCell(0, 6, "Fattura n: {$_REQUEST['index']} del: ".unformat_date($_REQUEST['data_pagamento']));
    $pdf->Ln();

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(90, 12, 'OGGETTO', 1, 0, 'C');
    $pdf->Cell(90, 12, 'IMPORTI', 1, 1, 'C');

    $count=0;
    $pdf->SetFont('Arial', '', 12);
    foreach($_REQUEST['table'] ?? [] as $row){

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

    $rows=2;
    if($count<$rows){
        for($i=0;$i<$rows-$count;$i++){
            $pdf->Cell(90, 10, '', 'LR', 0, 'L');
            $pdf->Cell(90, 10, '', 'R', 1, 'C');
        }
    }
    if((double)$_REQUEST['inps']>0){
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(90, 12, '  Rivalsa INPS (4%)', 'LR', 0, 'L');
        $pdf->Cell(90, 12, EURO." ".number_format($_REQUEST['inps'], 2, ',', '.'), 'R', 1, 'C');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(90, 12, '  Subtotale', 'LR', 0, 'L');
        $pdf->Cell(90, 12, EURO." ".number_format((double)$_REQUEST['inps']+(double)$_REQUEST['importo'], 2, ',', '.'), 'R', 1, 'C');
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
        'data'=>$_REQUEST['data_pagamento'],
        'metodo'=>$_REQUEST['metodo_pagamento'],
        'stato'=>$stato,
        'fatturato_da'=>$_REQUEST['is_isico']=='true'?'Isico':'Medplus'
    ];

    $save_pagamenti=[
        'id_cliente'=>$_REQUEST['id_cliente'],
        'origine'=>'fatture',
        'metodo'=>$_REQUEST['metodo_pagamento'],
        'data'=>$_REQUEST['data_pagamento'],
        'imponibile'=>$_REQUEST['importo'],
        'inps'=>$_REQUEST['inps'],
        'bollo'=>$_REQUEST['bollo'],
        'totale'=>((double)$_REQUEST['importo'] + (double)$_REQUEST['bollo'] + (double) $_REQUEST['inps']),
        'note'=>'-',
        'stato'=>$stato
    ];

    if(isset_n_valid($_REQUEST['oggetti'][0]['bnw'])){
        $save_pagamenti['bnw']=$_REQUEST['oggetti'][0]['bnw'];
    }

    if(isset($_REQUEST['id_fattura'])){
        $id_fattura=$_REQUEST['id_fattura'];
        $oggetti=Select('*,  id_origine as id_percorso')->from('pagamenti_fatture')->where("id_fattura={$id_fattura}")->get();
        $fatture=Select('*')->from('fatture')->where("id={$id_fattura}")->first();
        Update('pagamenti')->set($save_pagamenti)->where("id={$fatture['id_pagamenti']}");
        Update('fatture')->set($save)->where("id={$id_fattura}");
        Delete()->from('pagamenti_fatture')->where("id_fattura={$id_fattura}");
        Delete()->from('fatture_table')->where("id_fattura={$id_fattura}");
    }
    else{
        $id_pagamento=Insert($save_pagamenti)->into('pagamenti')->get();
        $save['id_pagamenti']=$id_pagamento;
        $id_fattura=Insert($save)->into('fatture')->get();
        $oggetti=$_REQUEST['oggetti'];
    }

    foreach($_REQUEST['table'] ?? [] as $row){
        $importo=$row['importo']==''?0:$row['importo'];
        Insert(['id_fattura'=>$id_fattura, 'oggetto'=>$row['oggetto'],'importo'=>$importo])->into('fatture_table');
    }

    $valore=(double)$_REQUEST['importo'];
    foreach($oggetti as $value){

        if($valore>0){

            $obj=Select('*')->from($value['view'])->where("id={$value['id']}")->first();

            $prezzo = (double)$obj['prezzo'];

            $saldato = $prezzo <= ($valore + (double)$obj['saldato']) ? ($prezzo - (double)$obj['saldato']) : $valore;

            switch($value['view']){
                case 'corsi_pagamenti':{
                    $origine='corsi';
                    $id_origine=$obj['id_corso'];
                    $id_origine_child=$obj['id'];
                    break;
                }
                case 'view_sedute':{
                    $origine='trattamenti';
                    $id_origine=$obj['id_percorso'];
                    $id_origine_child=$obj['id'];

                    Update('percorsi_terapeutici_sedute')->set([
                        'data_pagamento'=>$_REQUEST['_data']['data'] ?? $_REQUEST['data_pagamento'],
                        'tipo_pagamento'=>'Fattura',
                        'saldato'=>($saldato + (double)$obj['saldato']),
                        'stato_pagamento'=>(($saldato + (double)$obj['saldato']) < $prezzo ? 'Parziale' : 'Saldato')
                    ])->where("id={$obj['id']}");
                    break;
                }
            }
            
            Insert([
                'origine'=>$origine,
                'id_origine'=>$id_origine,
                'id_origine_child'=>$id_origine_child,
                'id_cliente'=>$_REQUEST['id_cliente'],
                'id_fattura'=>$id_fattura,
                'importo'=>$saldato
            ])->into('pagamenti_fatture');

            $valore= $valore - $saldato;

        }

    }
    $file=fatture_path($link);
    $pdf->Output('F', root($file));
    echo fatture_path($link);