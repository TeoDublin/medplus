<?php 
    function _view_percorsi(){
        $ret=Select('*')->from('view_percorsi')->where("id_cliente={$_REQUEST['id_cliente']}");
        if(!$_REQUEST['storico'])$ret->and("stato <> 'Concluso'");
        return $ret->get_or_false();
    }

    function _view_colloqui(){
        return Select('*,DATE_FORMAT(x.data,"%d/%m") as data_formated,TIME_FORMAT(x.ora_inizio,"%H:%i") as "ora_inizio_formated", TIME_FORMAT(x.ora_fine,"%H:%i") as "ora_fine_formated"')
        ->from('view_colloqui')
        ->where("id_cliente={$_REQUEST['id_cliente']}")
        ->get_or_false();
    }

    function _view_classi(){
        return Select('*')->from('view_classi')->where("id_cliente={$_REQUEST['id_cliente']} AND deleted = 0")->get_or_false();
    }

    function _view_pagamenti($id_corso){
        return Select('*')->from('view_pagamenti')->where("id_origine={$id_corso} AND id_cliente={$_REQUEST['id_cliente']} AND origine = 'corsi'")->get();
    }

    function _view_sedute($id_percorso){
        $session=Session();
        $ruolo=$session->get('ruolo')??'';
        $ret=Select('*')->from('view_sedute')->where("id_percorso={$id_percorso}");
        if(!$_REQUEST['storico'])$ret->and("( stato_seduta <> 'Conclusa' or NOT stato_pagamento IN('Saldato', 'Esente'))");
        if($ruolo=='display')$ret->and("( tipo_pagamento IS NULL OR tipo_pagamento <> 'Senza Fattura' )");
        $ret->orderby('`data_seduta` IS NULL,`data_seduta`, `index` ASC');
        return $ret->get();
    }
    
    function _percorsi_terapeutici_sedute_prenotate($id_seduta){
        return Select('sp.id,sp.stato_prenotazione,sp.data,t.terapista,TIME_FORMAT(pri.ora,"%H:%i") as "ora_inizio", TIME_FORMAT(prf.ora,"%H:%i") as "ora_fine"')
            ->from('percorsi_terapeutici_sedute_prenotate','sp')
            ->left_join('terapisti t on sp.id_terapista = t.id')
            ->left_join('planning_row pri on sp.row_inizio = pri.id')
            ->left_join('planning_row prf on sp.row_fine = prf.id')
            ->where("sp.id_seduta={$id_seduta}")
            ->get();
    }

    function _nome_terapista($nome){
        $explode=explode(' ',$nome);
        $is_first=true;
        foreach(array_filter($explode) as $nome){
            if($is_first){
                $is_first=false;
                $span_class='';
            }
            else $span_class='d-none d-md-block';            
            echo "<span class=\"me-1 {$span_class}\">{$nome}</span>";
        }
    }
    function _stato_pagamento($v){
        if((int)$v['saldato']>=(int)$v['prezzo']){
            return 'Saldato';
        }
        elseif($v['saldato']>0){
            return 'Parziale';
        }
        else{
            return 'Pendente';
        }
    }

    style('modal_component/percorsi/percorsi.css');
    $view_percorsi=_view_percorsi();
    $view_colloqui=_view_colloqui();
    $view_classi=_view_classi();
    $is_first=true;
?>
<div class="modal bg-dark bg-opacity-50" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog modal-xl" >
        <div class="modal-content" >
            <div class="modal-header"><h4 class="modal-title"><?php echo $_REQUEST['storico']?'Tutti i Percorsi':'Trattamenti in essere'; ?></h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="container"></div>
            <div class="modal-body">
                <div class="p-md-2">
                    <input type="text" id="id_cliente" value="<?php echo $_REQUEST['id_cliente']; ?>" hidden/>
                    <div class="container-fluid card text-center text-break flex-shrink-1 py-4">

                        <div id="del-sedute" class="d-flex w-100 justify-content-end d-none">
                            <div class="d-flex flex-row w-100 gap-3">
                                <button class="btn btn-warning w-100 d-flex flex-row align-items-center justify-content-center"
                                    onclick="window.modalHandlers['percorsi'].deleteSeduteClick(this,<?php echo $_REQUEST['id_cliente']; ?>);"
                                ><?php echo icon('bin.svg',25,25); ?><span class="text-center text-break flex-shrink-1">Elimina Sedute</span></button>
                            </div>
                        </div>

                        <?php if(!$view_percorsi&&!$view_colloqui&&!$view_classi){?>
                            <div class="card">
                                <div class="card-body">
                                    <span>Non ci sono trattamenti per questo cliente.</span>
                                </div>
                            </div><?php
                        }
                        else{ 

                            if($view_classi){?>
                                <div class="accordion mb-2" id="accordionFlushCorsi">
                                    <div class="accordion-item" >
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed border w-100" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseCorsi" aria-expanded="false" aria-controls="flush-collapseCorsi">
                                                <div class="w-100">
                                                    <div class="h-100 text-center d-grid align-content-center justify-contents-center" style="padding:0!important">
                                                        <h5 class="p-0 m-0">CORSI</h5>
                                                    </div>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseCorsi" class="accordion-collapse collapse" data-bs-parent="#accordionFlushCorsi">
                                            <div class="accordion-body">
                                                <!-- titles -->
                                                <div class="d-flex w-100 text-center" style="padding-right:40px;padding-left:20px">
                                                    <div class="w-5">
                                                        <div class="d-grid align-content-center justify-contents-center h-100">
                                                        </div>
                                                    </div>
                                                    <div class="w-20">
                                                        <div class="d-grid align-content-center justify-contents-center h-100">
                                                            Corso
                                                        </div>
                                                    </div>
                                                    <div class="w-20">
                                                        <div class="d-grid align-content-center justify-contents-center h-100">
                                                            Inizio
                                                        </div>
                                                    </div>
                                                    <div class="w-20">
                                                        <div class="d-grid align-content-center justify-contents-center h-100">
                                                            Prezzo
                                                        </div>
                                                    </div>
                                                    <div class="w-20">
                                                        <div class="d-grid align-content-center justify-contents-center h-100">
                                                            Realizato da
                                                        </div>
                                                    </div>
                                                    <div class="w-15">
                                                        <div class="d-grid align-content-center justify-contents-center h-100">
                                                            Voucher
                                                        </div>
                                                    </div>
                                                </div><?php 
                                                foreach ($view_classi as $key => $value) {
                                                    $view_pagamenti=_view_pagamenti($value['id_corso']);
                                                    ?>
                                                    <div class="accordion mb-2" id="accordionFlushCorso<?php echo $value['id'];?>">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button collapsed px-0 py-0 border text-center" style="padding-right:20px!important;padding-left:20px!important" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseCorso<?php echo $value['id'];?>" aria-expanded="false" aria-controls="flush-collapseCorso<?php echo $value['id'];?>">
                                                                    <div class="d-flex w-100 text-center">
                                                                        <div class="w-5">
                                                                            <div class="d-grid align-content-center justify-contents-center h-100">
                                                                                <?php echo icon('bin.svg','black',16,16); ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-20">
                                                                            <div class="d-grid align-content-center justify-contents-center h-100">
                                                                                <?php echo $value['corso']; ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-20">
                                                                            <div class="d-grid align-content-center justify-contents-center h-100">
                                                                                <?php echo unformat_date($value['data_inizio']); ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-20">
                                                                            <div class="d-grid align-content-center justify-contents-center h-100">
                                                                                <?php echo number_format($value['prezzo'],2,'.',''); ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-20">
                                                                            <div class="d-grid align-content-center justify-contents-center h-100">
                                                                                <?php echo $value['realizzato_da']; ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-15">
                                                                            <div class="d-grid align-content-center justify-contents-center h-100">
                                                                                <?php echo $value['bnw']; ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                            </h2>
                                                            <div id="flush-collapseCorso<?php echo $value['id'];?>" class="accordion-collapse collapse" data-bs-parent="#accordionFlushCorso<?php echo $value['id'];?>">
                                                                <div class="accordion-body">
                                                                    <!-- titles -->
                                                                    <div class="d-flex w-100 px-3 mb-2">

                                                                        <div class="w-20">
                                                                            <div class="d-grid h-100 align-content-center d-none d-md-block">
                                                                                Scadenza
                                                                            </div>
                                                                            <div class="d-grid h-100 align-content-center d-block d-md-none">
                                                                                Scd.
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-15">
                                                                            <div class="d-grid h-100 align-content-center">
                                                                                Prezzo
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-15">
                                                                            <div class="d-grid h-100 align-content-center">
                                                                                Saldato
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-15">
                                                                            <div class="d-grid h-100 align-content-center">
                                                                                Fatturato
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-15">
                                                                            <div class="d-grid h-100 align-content-center">
                                                                                Non Fatturato
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-20 d-none d-md-block">
                                                                            <div class="d-grid h-100 align-content-center">
                                                                                Stato Pagamento
                                                                            </div>
                                                                        </div>
                                                                    
                                                                    </div>
                                                                    
                                                                    <!-- corsi --><?php
                                                                    foreach ($view_pagamenti as $v) {
                                                                        $stato_pagamento=_stato_pagamento($v);
                                                                        ?>
                                                                        <div class="d-flex w-100 border p-3 hover" >
                                                                            <div class="w-20">
                                                                                <div class="d-grid h-100 align-content-center">
                                                                                    <?php echo unformat_date($v['scadenza']); ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="w-15">
                                                                                <div class="d-grid h-100 align-content-center prezzo">
                                                                                    <?php echo number_format($v['prezzo'],2,'.',''); ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="w-15">
                                                                                <div class="d-grid h-100 align-content-center prezzo">
                                                                                    <?php echo number_format($v['saldato'],2,'.',''); ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="w-15">
                                                                                <div class="d-grid h-100 align-content-center prezzo">
                                                                                    <?php echo number_format($v['fatturato'],2,'.',''); ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="w-15">
                                                                                <div class="d-grid h-100 align-content-center prezzo">
                                                                                    <?php echo number_format($v['non_fatturato'],2,'.',''); ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="w-20 d-none d-md-block">
                                                                                <div class="d-grid h-100 align-content-center">
                                                                                    <?php echo $stato_pagamento; ?>
                                                                                </div>
                                                                            </div>
                                                                        </div><?php
                                                                    }?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div><?php
                                                }?>
                                            </div>
                                        </div>
                                    </div>
                                </div><?php
                            }
                            
                            if($view_percorsi){?>
                                <div class="accordion mb-2" id="accordionFlushTrattamenti">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTrattamenti" aria-expanded="false" aria-controls="flush-collapseTrattamenti">
                                                <div class="w-100">
                                                    <div class="h-100 text-center d-grid align-content-center justify-contents-center" style="padding:0!important">
                                                        <h5 class="p-0 m-0">TRATTAMENTI</h5>
                                                    </div>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseTrattamenti" class="accordion-collapse collapse" data-bs-parent="#accordionFlushTrattamenti">
                                            <div class="accordion-body">
                                                <!-- titles -->
                                                <div class="table-responsive">
                                                    <div class="my-0">
                                                        <div class="flex-row titles w-100 d-flex">
                                                            <div class="cc1 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1">
                                                                <span></span>
                                                            </div>
                                                            <div class="cc2 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1">
                                                                <span>Trattamento</span>
                                                            </div>
                                                            <div class="cc3 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1">
                                                                <span>Realizzato da</span>
                                                            </div>
                                                            <div class="cc3 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1 d-none d-md-block">
                                                                <span>Inizio</span>
                                                            </div>
                                                            <div class="cc3 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1">
                                                                <span class="d-none d-md-block">Prezzo</span>
                                                                <span class="d-md-none">$</span>
                                                            </div>
                                                            <div class="cc1 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1">
                                                                <span>N</span><span class="d-none d-md-block">ote</span>
                                                            </div>
                                                          <div class="cc3 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1">
                                                                <span>V</span><span class="d-none d-md-block">oucher</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- accordions -->
                                                <?php foreach ($view_percorsi as $percorso) {
                                                    $view_sedute=_view_sedute($percorso['id']);?>
                                                    <div class="accordion" id="accordion-percorso<?php echo $percorso['id'];?>">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <div class="accordion-button border py-2 collapsed <?php echo $percorso['stato']; ?>" name="row_percorso" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-percorso<?php echo $percorso['id'];?>" aria-expanded="false" aria-controls="collapse-percorso<?php echo $percorso['id'];?>">
                                                                    <div class="d-flex flex-row w-100">
                                                                        <input value="<?php echo $percorso['id'];?>" name="id_percorso" hidden/>
                                                                        <div class="cc1 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1" 
                                                                            onclick="window.modalHandlers['percorsi'].deleteClick(this)" 
                                                                            onmouseenter="window.modalHandlers['percorsi'].deleteEnter(this)" 
                                                                            onmouseleave="window.modalHandlers['percorsi'].deleteLeave(this)">
                                                                            <?php echo icon('bin.svg','black',16,16); ?>
                                                                        </div>
                                                                        <div class="cc2 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1"
                                                                                title=""
                                                                                data-bs-toggle="popover"
                                                                                data-bs-placement="right"
                                                                                data-bs-title="Trattamenti"
                                                                                data-bs-html="true"
                                                                                data-bs-content="<?php echo str_replace(';', '<br>', htmlspecialchars($percorso['trattamento'], ENT_QUOTES, 'UTF-8')); ?>"
                                                                                onmouseenter="window.modalHandlers['percorsi'].acronimoEnter(this)"
                                                                                onmouseleave="window.modalHandlers['percorsi'].acronimoLeave(this)"
                                                                            >
                                                                            <span><?php echo $percorso['acronimo']; ?></span>
                                                                        </div>
                                                                        <div class="cc3 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1 d-none d-md-flex"><span><?php echo $percorso['realizzato_da']; ?></span></div>
                                                                        <div class="cc3 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1 d-none d-md-flex"><span><?php echo format($percorso['timestamp'],'d/m/Y'); ?></span></div>
                                                                        <div class="cc3 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1"><span><?php echo $percorso['prezzo']; ?></span></div>
                                                                        <div class="cc1 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1"
                                                                                title=""
                                                                                data-bs-toggle="popover"
                                                                                data-bs-placement="right"
                                                                                data-bs-title="Note"
                                                                                data-bs-content="<?php echo $percorso['note']; ?>"
                                                                                onmouseenter="window.modalHandlers['percorsi'].noteEnter(this)"
                                                                                onmouseleave="window.modalHandlers['percorsi'].noteLeave(this)"
                                                                            >
                                                                            <?php echo icon('info.svg','black',20,20); ?>
                                                                        </div>
                                                                        <div class="cc3 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1">
                                                                            <span><?php echo $percorso['bnw']; ?></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </h2>
                                                            <div id="collapse-percorso<?php echo $percorso['id'];?>" class="accordion-collapse collapse" data-bs-parent="#accordion-percorso<?php echo $percorso['id'];?>">
                                                                <div class="container-fluid card text-center text-break flex-shrink-1 pt-4"><?php 
                                                                    if(empty($view_sedute)){?>
                                                                        <div class="card">
                                                                            <div class="card-body">
                                                                                <span>Non ci sono sedute per questo percorso.</span>
                                                                            </div>
                                                                        </div><?php
                                                                    }
                                                                    else{ ?>
                                                                        <div class="table-responsive">
                                                                            <div class="my-0">
                                                                                <div class="flex-row titles w-100 d-flex flex-wrap">
                                                                                    <div class="w-5 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1">
                                                                                        <span></span>
                                                                                    </div>
                                                                                    <div class="w-10 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1">
                                                                                        <span class="d-none d-md-block">Seduta</span>
                                                                                        <span class="d-md-none">n</span>
                                                                                    </div>
                                                                                    <div class="w-10 d-none d-md-flex align-items-center justify-content-center text-center text-break flex-shrink-1">
                                                                                        <span>Prezzo</span>
                                                                                    </div>
                                                                                    <div class="w-25 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1">
                                                                                        <span class="d-none d-md-block">Stato Pagamento</span>
                                                                                        <span class="d-md-none">$</span>
                                                                                    </div>
                                                                                    <div class="flex-fill d-flex align-items-center justify-content-center text-center text-break flex-shrink-1">
                                                                                        <span class="d-none d-md-block">Stato Seduta</span>
                                                                                        <span class="d-md-none">Seduta</span>
                                                                                    </div>
                                                                                    <div class="w-25 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1">
                                                                                        <span class="d-none d-md-block">Stato Prenotazione</span>
                                                                                        <span class="d-md-none">Pren.</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php foreach ($view_sedute as $seduta) {
                                                                            $sedute_prenotate=_percorsi_terapeutici_sedute_prenotate($seduta['id']);
                                                                            $abble=in_array($seduta['stato_seduta'],['Pendente','Assente','Spostata']);
                                                                            $debitore=$seduta['stato_seduta']=='Conclusa'&&$seduta['stato_pagamento']=='Pendente';
                                                                            ?>
                                                                            <div class="accordion" id="accordionSeduta<?php echo $seduta['id'];?>">
                                                                                <div class="accordion-item">
                                                                                    <h2 class="accordion-header">
                                                                                        <div class="accordion-button collapsed border py-2 <?php echo $seduta['stato_seduta']; ?>" type="button" data-bs-toggle="collapse"  name="row_percorso" data-bs-target="#collapseSeduta<?php echo $seduta['id'];?>" aria-expanded="false" aria-controls="collapseSeduta<?php echo $seduta['id'];?>">
                                                                                            <input value="<?php echo $seduta['id'];?>" name="id_seduta" hidden/>
                                                                                            <div class="d-flex flex-row w-100 flex-wrap">
                                                                                                <div class="w-5 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1">
                                                                                                    <?php 
                                                                                                        if($abble){?>
                                                                                                            <input type="checkbox" class="form-check w-100"
                                                                                                                onclick="window.modalHandlers['percorsi'].check(this)"
                                                                                                            ><?php
                                                                                                        }
                                                                                                        else{?>
                                                                                                            <input type="checkbox" class="form-check w-100" disabled><?php
                                                                                                        }
                                                                                                    ?>
                                                                                                    
                                                                                                </div>
                                                                                                <div class="w-10 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1"><span><?php echo $seduta['index']; ?></span></div>
                                                                                                <div class="w-10 d-none d-md-flex align-items-center justify-content-center text-center text-break flex-shrink-1"><span><?php echo $seduta['prezzo']; ?></span></div>
                                                                                                <div class="w-25 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1 div-<?php echo $debitore?'Debitore':$seduta['stato_pagamento']; ?>">
                                                                                                    <span>
                                                                                                        <?php 
                                                                                                            if($debitore){
                                                                                                                echo 'Debitore';
                                                                                                            }
                                                                                                            elseif($seduta['stato_pagamento']=='Parziale'){
                                                                                                                echo "Parziale (".($seduta['prezzo']-$seduta['saldato']).")";
                                                                                                            }
                                                                                                            else{
                                                                                                                echo $seduta['stato_pagamento'];
                                                                                                            }
                                                                                                        ?>
                                                                                                    </span></div>
                                                                                                <div class="flex-fill d-flex align-items-center justify-content-center text-center text-break flex-shrink-1 div-<?php echo $seduta['stato_seduta']; ?>"><span><?php echo $seduta['stato_seduta']; ?></span></div>
                                                                                                <div class="w-25 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1">
                                                                                                    <?php if($abble){?>
                                                                                                        <button class="btn btn-primary flex-fill" 
                                                                                                        onclick="window.modalHandlers['percorsi'].prenotaSeduteClick(<?php echo $seduta['id'].','.$_REQUEST['id_cliente'].','.$percorso['id']; ?>)" 
                                                                                                        onmouseenter="window.modalHandlers['percorsi'].prenotaEnter(this)" 
                                                                                                        onmouseleave="window.modalHandlers['percorsi'].prenotaLeave(this)">PRENOTA</button><?php
                                                                                                    }
                                                                                                    else{?>
                                                                                                        <button class="btn btn-dark flex-fill" disabled><?php echo strtoupper($seduta['stato_seduta']);?> </button><?php
                                                                                                    }?>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </h2>
                                                                                    <div id="collapseSeduta<?php echo $seduta['id'];?>" class="accordion-collapse collapse" data-bs-parent="#accordionSeduta<?php echo $seduta['id'];?>">
                                                                                        <?php if(empty($sedute_prenotate)){?>
                                                                                            <div class="card">
                                                                                                <div class="card-body">
                                                                                                    <span>Non ci sono sedute prenotate.</span>
                                                                                                </div>
                                                                                            </div><?php
                                                                                        }
                                                                                        else{ ?>
                                                                                            <div class="table-responsive">
                                                                                                <div class="my-0">
                                                                                                    <div class="flex-row seduta-titles w-100 d-flex">
                                                                                                        <div class="csp1 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1">
                                                                                                            <span>Terapista</span>
                                                                                                        </div>
                                                                                                        <div class="csp2 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1">
                                                                                                            <span>Data</span>
                                                                                                        </div>
                                                                                                        <div class="csp2 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1">
                                                                                                            <span>Inizio</span>
                                                                                                        </div>
                                                                                                        <div class="csp2 d-flex d-none d-md-block align-items-center justify-content-center text-center text-break flex-shrink-1">
                                                                                                            <span>Fine</span>
                                                                                                        </div>
                                                                                                        <div class="csp4 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1">
                                                                                                            <span>Stato</span>
                                                                                                        </div>
                                                                                                        <div class="csp3 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1">
                                                                                                            <span>#</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <?php foreach($sedute_prenotate as $seduta_prenotata){?>
                                                                                                        <div class="flex-row seduta-titles w-100 d-flex ">
                                                                                                            <div class="csp1 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1"><?php _nome_terapista($seduta_prenotata['terapista']); ?></div>
                                                                                                            <div class="csp2 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1"><span><?php echo italian_date($seduta_prenotata['data'],"%a %d/%m"); ?></span></div>
                                                                                                            <div class="csp2 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1"><span><?php echo $seduta_prenotata['ora_inizio']; ?></span></div>
                                                                                                            <div class="csp2 d-flex d-none d-md-block align-items-center justify-content-center text-center text-break flex-shrink-1"><span><?php echo $seduta_prenotata['ora_fine']; ?></span></div>
                                                                                                            <div class="csp4 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1 statoHover">
                                                                                                                <select type="text" class="form-control text-center text-break flex-shrink-1" id="stato_prenotazione" value="<?php echo $seduta_prenotata['stato_prenotazione']??'';?>" 
                                                                                                                    onchange="window.modalHandlers['percorsi'].changeStatoPrenotazione(this,<?php echo $seduta_prenotata['id'].','.$seduta['id'];?>)">
                                                                                                                    <?php 
                                                                                                                        foreach(Enum('percorsi_terapeutici_sedute_prenotate','stato_prenotazione')->list as $value){
                                                                                                                            $selected = (isset($seduta_prenotata['stato_prenotazione']) && $seduta_prenotata['stato_prenotazione'] == $value) ? 'selected' : '';
                                                                                                                            echo "<option value=\"{$value}\" class=\"ps-4  bg-white\" {$selected}>{$value}</option>";
                                                                                                                        }
                                                                                                                    ?>
                                                                                                                </select>
                                                                                                            </div>
                                                                                                            <div class="csp3 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1 delHover" 
                                                                                                                onclick="window.modalHandlers['percorsi'].deleteSedutaPrenotata(this,<?php echo $seduta_prenotata['id'].','.$percorso['id'].','.$seduta['id']; ?>)" 
                                                                                                                onmouseenter="window.modalHandlers['percorsi'].enterSedutaPrenotata(this);" 
                                                                                                                onmouseleave="window.modalHandlers['percorsi'].leaveSedutaPrenotata(this);">
                                                                                                                <?php echo icon('bin.svg','black',16,16); ?></div>
                                                                                                        </div><?php                                        
                                                                                                    } ?>
                                                                                                </div>
                                                                                            </div><?php
                                                                                        }?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <p class="psm"><?php
                                                                        }                                                   
                                                                    }?>
                                                                    <div class="d-flex flex-row w-100 gap-3 py-3">
                                                                        <button class="btn btn-primary w-100 d-flex flex-row align-items-center justify-content-center gap-3"
                                                                            onclick="window.modalHandlers['percorsi'].addSeduteClick(<?php echo $_REQUEST['id_cliente'].','.$percorso['id'].','.$percorso['id_combo']; ?>);"
                                                                        ><span class="text-center text-break flex-shrink-1">Aggiungi Sedute</span></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="psm"><?php
                                                }?>
                                            </div>
                                        </div>
                                    </div>
                                </div><?php
                            }

                            if($view_colloqui) {?>
                                <div class="accordion" id="accordion-colloqui">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <div class="accordion-button border py-2 collapsed" name="row_colloqui" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-colloqui" aria-expanded="false" aria-controls="collapse-colloqui">
                                                <div class="d-flex flex-row w-100">
                                                    <div class="flex-fill d-flex align-items-center justify-content-center text-center text-break flex-shrink-1">
                                                        <h5 class="p-0 m-0">COLLOQUIO</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </h2>
                                        <div id="collapse-colloqui" class="accordion-collapse collapse" data-bs-parent="#accordion-colloqui">
                                            <div class="container-fluid card text-center text-break flex-shrink-1 pt-4">
                                                <div class="table-responsive">
                                                    <div class="my-0">
                                                        <div class="flex-row seduta-titles w-100 d-flex">
                                                            <div class="csp1 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1">
                                                                <span>Terapista</span>
                                                            </div>
                                                            <div class="csp2 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1">
                                                                <span>Data</span>
                                                            </div>
                                                            <div class="csp2 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1">
                                                                <span>Inizio</span>
                                                            </div>
                                                            <div class="csp2 d-flex d-none d-md-block align-items-center justify-content-center text-center text-break flex-shrink-1">
                                                                <span>Fine</span>
                                                            </div>
                                                            <div class="csp4 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1">
                                                                <span>Stato</span>
                                                            </div>
                                                            <div class="csp3 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1">
                                                                <span>#</span>
                                                            </div>
                                                        </div>
                                                        <?php foreach ($view_colloqui as $colloquio) {?>
                                                            <div class="flex-row seduta-titles w-100 d-flex ">
                                                                <div class="csp1 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1"><?php _nome_terapista($colloquio['terapista']); ?></div>
                                                                <div class="csp2 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1"><span><?php echo $colloquio['data_formated']; ?></span></div>
                                                                <div class="csp2 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1"><span><?php echo $colloquio['ora_inizio_formated']; ?></span></div>
                                                                <div class="csp2 d-flex d-none d-md-block align-items-center justify-content-center text-center text-break flex-shrink-1"><span><?php echo $colloquio['ora_fine_formated']; ?></span></div>
                                                                <div class="csp4 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1 statoHover">
                                                                    <select type="text" class="form-control text-center text-break flex-shrink-1" id="colloquio_stato_prenotazione" value="<?php echo $colloquio['stato_prenotazione']??'';?>" 
                                                                        onchange="window.modalHandlers['percorsi'].changeStatoColloquio(this,<?php echo $colloquio['id'];?>)">
                                                                        <?php 
                                                                            foreach(Enum('colloquio_planning','stato_prenotazione')->list as $value){
                                                                                $selected = (isset($colloquio['stato_prenotazione']) && $colloquio['stato_prenotazione'] == $value) ? 'selected' : '';
                                                                                echo "<option value=\"{$value}\" class=\"ps-4  bg-white\" {$selected}>{$value}</option>";
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="csp3 d-flex align-items-center justify-content-center text-center text-break flex-shrink-1 delHover" 
                                                                    onclick="window.modalHandlers['percorsi'].deleteColloquio(this,<?php echo $colloquio['id']; ?>)" 
                                                                    onmouseenter="window.modalHandlers['percorsi'].enterColloquio(this);" 
                                                                    onmouseleave="window.modalHandlers['percorsi'].leaveColloquio(this);">
                                                                    <?php echo icon('bin.svg','black',16,16); ?></div>
                                                            </div><?php                                        
                                                        }?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="psm"><?php
                            }

                        }?>
                        <div class="d-flex mt-2" >
                            <button class="btn btn-primary flex-fill" onclick="window.modalHandlers['percorsi'].btnPercorsoClick(<?php echo $_REQUEST['id_cliente']; ?>)">Trattamento</button>
                            <button class="btn btn-secondary w-50 ms-2" onclick="window.modalHandlers['percorsi'].btncolloquioClick(<?php echo $_REQUEST['id_cliente']; ?>)">Colloquio</button>
                        </div>
                    </div>
                </div>
                <div class="p-md-2" id="prenota_planning"></div>
                <div class="p-md-2" id="percorso_combo"></div>
                <div class="p-md-2" id="prenota_colloquio"></div>
                <div class="p-md-2" id="sedute"></div>
                <div class="p-md-2" id="add_sedute"></div>
            </div>
        </div>
    </div>
</div>
<?php modal_script('percorsi'); ?>