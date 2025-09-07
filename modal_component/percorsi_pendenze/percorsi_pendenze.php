<?php 
    $session=Session();
    $ruolo=$session->get('ruolo')??false;

    function _view_pagamenti($origine){
        return Select('*')
        ->from('view_pagamenti')
        ->where("id_cliente={$_REQUEST['id_cliente']} AND saldato < prezzo AND origine = '{$origine}'")
        ->orderby('origine ASC, scadenza ASC')
        ->get();
    }

    function _view_sedute($id_percorso){
        return Select('*')->from('view_sedute')->where("id_percorso={$id_percorso}")->get();
    }

    function _corsi(){
        if(empty($_view_pagamenti=_view_pagamenti('corsi'))) return [];
        $ret=[];
        foreach($_view_pagamenti as $k=>$v){
            if(!isset($ret[$v['id_origine']])){
                $ret[$v['id_origine']] = $v;
            }
            else{
                $ret[$v['id_origine']]['prezzo_tabellare'] += $v['prezzo_tabellare'];
                $ret[$v['id_origine']]['prezzo'] += $v['prezzo'];
                $ret[$v['id_origine']]['saldato'] += $v['saldato'];
                $ret[$v['id_origine']]['fatturato'] += $v['fatturato'];
                $ret[$v['id_origine']]['non_fatturato'] += $v['non_fatturato'];
            }
            $ret[$v['id_origine']]['corsi'][]=$v;
        }
        return $ret;
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

    function _cliente(){
        return Select('*')->from('clienti')->where("id={$_REQUEST['id_cliente']}")->first_or_false();
    }

    style('modal_component/percorsi_pendenze/percorsi_pendenze.css');
    $trattamenti=_view_pagamenti('trattamenti');
    $corsi=_corsi();

?>

<!-- modal -->
<div class="modal bg-dark bg-opacity-50" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Pendenze</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>                
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="container"></div>
            <div class="modal-body">
                <div class="p-2">
                    <input type="text" id="id_cliente" value="<?php echo $_REQUEST['id_cliente']; ?>" hidden/>
                    <div class="container-fluid card text-center py-4">
                        <?php if(!$trattamenti&&!$corsi){?>
                            <div class="card">
                                <div class="card-body">
                                    <span>Non ci sono percorsi pendenti per questo cliente.</span>
                                </div>
                            </div><?php
                        }
                        else{
                            if($corsi){?>
                                <div class="accordion mb-2" id="accordionFlushCorsi">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed border" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseCorsi" aria-expanded="false" aria-controls="flush-collapseCorsi">
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
                                                <div class="d-flex w-100 mb-2" style="padding-left:20px;padding-right:40px">
                                                    <div class="w-50">
                                                        <div class="d-grid h-100 align-content-center d-none d-md-block">
                                                            Corso
                                                        </div>
                                                    </div>
                                                    <div class="w-50">
                                                        <div class="d-grid h-100 align-content-center">
                                                            Realizato da
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- collapses --><?php 
                                                foreach ($corsi as $key=>$value) {?>
                                                    <div class="accordion mb-2" id="accordionFlushCorso<?php echo $value['id'];?>">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button collapsed border text-center" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseCorso<?php echo $value['id'];?>" aria-expanded="false" aria-controls="flush-collapseCorso<?php echo $value['id'];?>">
                                                                    <div class="w-50">
                                                                        <div class="d-grid h-100 align-content-center fw-bold">
                                                                            <?php echo strtoupper($value['nome']); ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="w-50">
                                                                        <div class="d-grid h-100 align-content-center">
                                                                            <?php echo $value['realizzato_da']; ?>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                            </h2>
                                                            <div id="flush-collapseCorso<?php echo $value['id'];?>" class="accordion-collapse collapse" data-bs-parent="#accordionFlushCorso<?php echo $value['id'];?>">
                                                                <div class="accordion-body">
                                                                    <!-- titles -->
                                                                    <div class="d-flex w-100 px-3 mb-2">
                                                                        <div class="w-5">
                                                                            <div class="d-grid h-100 align-content-center">
                                                                                #
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-15">
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
                                                                    foreach ($value['corsi'] as $v) {
                                                                        $stato_pagamento=_stato_pagamento($v);
                                                                        $abble=in_array($stato_pagamento,['Pendente','Parziale']);
                                                                        ?>
                                                                        <div 
                                                                            class="d-flex w-100 border p-3 hover <?php echo $abble?'':'disabled'; ?>" 
                                                                            onclick="window.modalHandlers['percorsi_pendenze'].check(this)"
                                                                            data-id="<?php echo $v['id'];?>"
                                                                            data-realizzato_da="<?php echo $v['realizzato_da'];?>"
                                                                            data-view="corsi_pagamenti"
                                                                            >
                                                                            <div class="w-5 ">
                                                                                <?php 
                                                                                    if($abble){?>
                                                                                        <input type="checkbox" class="form-check w-100"><?php
                                                                                    }
                                                                                    else{?>
                                                                                        <input type="checkbox" class="form-check w-100" disabled><?php
                                                                                    }
                                                                                ?>
                                                                                
                                                                            </div>
                                                                            <div class="w-15">
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

                            if($trattamenti){?>
                                <div class="accordion mb-2" id="accordionFlushTrattamentii">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed border" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTrattamenti" aria-expanded="false" aria-controls="flush-collapseTrattamenti">
                                                <div class="w-100">
                                                    <div class="h-100 text-center d-grid align-content-center justify-contents-center" style="padding:0!important">
                                                        <h5 class="p-0 m-0">TRATTAMENTI</h5>
                                                    </div>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseTrattamenti" class="accordion-collapse collapse" data-bs-parent="#accordionFlushTrattamentii">
                                            <div class="accordion-body">
                                                <!-- titles -->
                                                <div class="d-flex w-100 mb-2" style="padding-left:20px;padding-right:40px">
                                                    <div class="w-md-25">
                                                        <div class="d-grid h-100 align-content-center">
                                                            Percorso
                                                        </div>
                                                    </div>
                                                    <div class="w-15 d-none d-md-block">
                                                        <div class="d-grid h-100 align-content-center">
                                                            Tabellare
                                                        </div>                                    
                                                    </div>
                                                    <div class="w-10">
                                                        <div class="d-grid h-100 align-content-center">
                                                            Prezzo
                                                        </div>
                                                    </div>
                                                    <div class="w-10 d-none d-md-block">
                                                        <div class="d-grid h-100 align-content-center">
                                                            Saldato
                                                        </div>
                                                    </div>
                                                    <div class="w-10 d-none d-md-block">
                                                        <div class="d-grid h-100 align-content-center">
                                                            Fatturato
                                                        </div>
                                                    </div>
                                                    <div class="w-10">
                                                        <div class="d-grid h-100 align-content-center">
                                                            Non Fatturato
                                                        </div>
                                                    </div>
                                                    <div class="w-20">
                                                        <div class="d-grid h-100 align-content-center">
                                                            Realizato da
                                                        </div>
                                                    </div>
                                                    
                                                </div>

                                                <!-- collapses --><?php 
                                                foreach ($trattamenti as $key => $value) {?>

                                                    <div class="d-flex w-100 mb-2">
                                                        <div class="accordion w-100 mt-1 px-0" id="accordionFlush<?php echo $value['id'];?>">
                                                            <div class="accordion-item px-0">
                                                                <h2 class="accordion-header">
                                                                <button class="accordion-button collapsed text-center" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?php echo $value['id'];?>" aria-expanded="false" aria-controls="flush-collapse<?php echo $value['id'];?>">
                                                                    <div class="d-flex w-100">
                                                                        <div class="w-md-25">
                                                                            <div class="d-grid h-100 align-content-center fw-bold">
                                                                                <?php echo strtoupper($value['acronimo']);?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-15 d-none d-md-block">
                                                                            <div class="d-grid h-100 align-content-center">
                                                                                <?php echo number_format($value['prezzo_tabellare'], 2, '.', ''); ?>
                                                                            </div>                                    
                                                                        </div>
                                                                        <div class="w-10">
                                                                            <div class="d-grid h-100 align-content-center">
                                                                                <?php echo number_format($value['prezzo'], 2, '.', ''); ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-10 d-none d-md-block">
                                                                            <div class="d-grid h-100 align-content-center">
                                                                                <?php echo number_format($value['saldato'], 2, '.', ''); ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-10 d-none d-md-block">
                                                                            <div class="d-grid h-100 align-content-center">
                                                                                <?php echo number_format($value['fatturato'], 2, '.', ''); ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-10">
                                                                            <div class="d-grid h-100 align-content-center">
                                                                                <?php echo number_format($value['non_fatturato'], 2, '.', ''); ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-20">
                                                                            <div class="d-grid h-100 align-content-center">
                                                                                <?php echo $value['realizzato_da']; ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                                </h2>
                                                                <div id="flush-collapse<?php echo $value['id'];?>" class="accordion-collapse collapse" data-bs-parent="#accordionFlush<?php echo $value['id'];?>">
                                                                    <div class="accordion-body text-center">

                                                                        <!-- titles -->
                                                                        <div class="d-flex w-100 px-3 mb-2">
                                                                            <div class="w-5">
                                                                                <div class="d-grid h-100 align-content-center">
                                                                                    #
                                                                                </div>
                                                                            </div>
                                                                            <div class="w-20">
                                                                                <div class="d-grid h-100 align-content-center">
                                                                                    Seduta
                                                                                </div>
                                                                            </div>
                                                                            <div class="w-20">
                                                                                <div class="d-grid h-100 align-content-center d-none d-md-block">
                                                                                    Scadenza
                                                                                </div>
                                                                                <div class="d-grid h-100 align-content-center d-block d-md-none">
                                                                                    N.
                                                                                </div>
                                                                            </div>
                                                                            <div class="w-25">
                                                                                <div class="d-grid h-100 align-content-center">
                                                                                    Prezzo
                                                                                </div>
                                                                            </div>
                                                                            <div class="w-25 d-none d-md-block">
                                                                                <div class="d-grid h-100 align-content-center">
                                                                                    Stato Pagamento
                                                                                </div>
                                                                            </div>
                                                                            <div class="w-md-25">
                                                                                <div class="d-grid h-100 align-content-center">
                                                                                    Stato Seduta
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <!-- sedute --><?php
                                                                        foreach (_view_sedute($value['id']) as $v) {
                                                                            $abble=in_array($v['stato_pagamento'],['Pendente','Parziale']);
                                                                            ?>
                                                                            <div 
                                                                                class="d-flex w-100 border p-3 hover <?php echo $abble?'':'disabled'; ?>" 
                                                                                onclick="window.modalHandlers['percorsi_pendenze'].check(this)"
                                                                                data-id="<?php echo $v['id'];?>"
                                                                                data-realizzato_da="<?php echo $v['realizzato_da'];?>"
                                                                                data-view="view_sedute"
                                                                                >
                                                                                <div class="w-5 ">
                                                                                    <?php 
                                                                                        if($abble){?>
                                                                                            <input type="checkbox" class="form-check w-100"><?php
                                                                                        }
                                                                                        else{?>
                                                                                            <input type="checkbox" class="form-check w-100" disabled><?php
                                                                                        }
                                                                                    ?>
                                                                                    
                                                                                </div>
                                                                                <div class="w-20">
                                                                                    <div class="d-grid h-100 align-content-center">
                                                                                        <?php echo $v['index']; ?>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="w-20">
                                                                                    <div class="d-grid h-100 align-content-center">
                                                                                        <?php echo unformat_date($v['data_seduta']); ?>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="w-25">
                                                                                    <div class="d-grid h-100 align-content-center prezzo">
                                                                                        <?php echo number_format($v['prezzo'],2,'.',''); ?>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="w-25 d-none d-md-block">
                                                                                    <div class="d-grid h-100 align-content-center">
                                                                                        <?php echo $v['stato_pagamento']; ?>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="w-md-25">
                                                                                    <div class="d-grid h-100 align-content-center">
                                                                                        <?php echo $v['stato_seduta']; ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div><?php
                                                                        }?>

                                                                    </div>
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
                        }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- buttons -->
<div class="floating-btns bg-dark d-none">
    <div class="position-relative">
        <div class="d-flex w-100 flex-wrap">
            <div class="d-flex me-1 mt-1 w-md-33 hover" onclick="window.modalHandlers['percorsi_pendenze'].uncheckAll()">
                <div class="d-flex flex-row btn btn-light flex-fill">
                    <div class="d-grid justify-content-center align-items-center me-1">
                        <?php echo icon('x.svg','black',20,20); ?>
                    </div>
                    <div class="d-grid justify-content-center align-items-center">
                        Rimuovi Selezione
                    </div>
                </div>
            </div>
            <div class="d-flex me-1 mt-1 w-md-33" onclick="window.modalHandlers['percorsi_pendenze'].changePrice(<?php echo $_REQUEST['id_cliente'];?>)">
                <div class="d-flex flex-row btn btn-light flex-fill">
                    <div class="d-grid justify-content-center align-items-center me-1">
                        <?php echo icon('edit.svg','black',20,20); ?>
                    </div>
                    <div class="d-grid justify-content-center align-items-center">
                        Modifica prezzo
                    </div>
                </div>
            </div>
            <div class="d-flex me-1 mt-1 flex-fill" onclick="window.modalHandlers['percorsi_pendenze'].del(<?php echo $_REQUEST['id_cliente'];?>)">
                <div class="d-flex flex-row btn btn-light flex-fill">
                    <div class="d-grid justify-content-center align-items-center me-1">
                        <?php echo icon('bin.svg','black',20,20); ?>
                    </div>
                    <div class="d-grid justify-content-center align-items-center">
                        Elimina Selezione
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex w-100 flex-wrap">
            <div class= "d-flex me-1 mt-1 w-md-33" 
                onclick="window.modalHandlers['percorsi_pendenze'].fatturaClick();">
                <div class="d-flex flex-row btn btn-primary flex-fill">
                    <div class="d-grid justify-content-center align-items-center me-1">
                        <?php echo icon('document.svg','white',20,20); ?>
                    </div>
                    <div class="d-grid justify-content-center align-items-center">
                        Fattura
                    </div>
                </div>
            </div>
            <div class= "d-flex me-1 mt-1 w-md-33" onclick="window.modalHandlers['percorsi_pendenze'].arubaClick(<?php echo $_REQUEST['id_cliente'];?>);">
                <div class="d-flex flex-row btn btn-primary flex-fill">
                    <div class="d-grid justify-content-center align-items-center me-1">
                        <?php echo icon('document.svg','white',20,20); ?>
                    </div>
                    <div class="d-grid justify-content-center align-items-center">
                        Fatturato Aruba
                    </div>
                </div>
            </div>
            <?php 
                if($ruolo!='display'){?>
                    <div class= "d-flex me-1 mt-1 flex-fill" onclick="window.modalHandlers['percorsi_pendenze'].senzaFatturaClick(<?php echo $_REQUEST['id_cliente'];?>);">
                        <div class="d-flex flex-row btn btn-primary flex-fill">
                            <div class="d-grid justify-content-center align-items-center me-1">
                                <?php echo icon('coin.svg','white',20,20); ?>
                            </div>
                            <div class="d-grid justify-content-center align-items-center">
                                Contanti
                            </div>
                        </div>
                    </div><?php
                }
                else{?>
                    <div class= "d-flex me-1 mt-1 flex-fill" onclick="window.modalHandlers['percorsi_pendenze'].senzaFatturaClick(<?php echo $_REQUEST['id_cliente'];?>);">
                        <div class="d-flex flex-row btn btn-primary flex-fill">
                            <div class="d-grid justify-content-center align-items-center me-1">
                                <?php echo icon('coin.svg','white',20,20); ?>
                            </div>
                            <div class="d-grid justify-content-center align-items-center">
                                Pagamento Isico
                            </div>
                        </div>
                    </div><?php
                }
            ?>  
        </div>
        <div>
            <div class="w-100 d-flex d-row mt-2 p-2">
                <div class="m-auto">
                    <div class="d-flex flex-row" style="color:white;font-size:20px">
                        <div class="me-1">Totale Selezionato:</div>
                        <div class="fw-bold" id="sum-selected">0</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="json/object" id="data_cliente">
    <?php echo json_encode(_cliente()); ?>
</script>

<div id="fattura"></div>
<div id="senza_fattura"></div>
<div id="fatturato_aruba"></div>
<div id="percorso_combo"></div>
<div id="prezzo_corso"></div>
<div id="percorsi_modifica_prezzo"></div>
<?php module_script('fattura'); ?>
<?php modal_script('percorsi_pendenze'); ?>