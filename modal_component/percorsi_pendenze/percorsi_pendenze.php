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
        return Select('*')
            ->from('view_sedute')
            ->where("id_percorso={$id_percorso}")
            ->orderby('`data_seduta` IS NULL,`data_seduta`, `index` ASC')
            ->get();
    }

    function _corsi(){

        $ret=[];

        if(empty($_view_pagamenti=_view_pagamenti('corsi'))){
            return [];
        }
        
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

    function _cliente(){
        return Select('*')->from('clienti')->where("id={$_REQUEST['id_cliente']}")->first_or_false();
    }

    style('modal_component/percorsi_pendenze/percorsi_pendenze.css');
    $trattamenti=_view_pagamenti('trattamenti');
    $corsi=_corsi();

?>

<!-- modal -->
<div class="modal bg-dark bg-opacity-50" id="<?= $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Pendenze</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?= $_REQUEST['id_modal'];?>')"></button>                
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="container"></div>
            <div class="modal-body">
                <div class="p-2">
                    <input type="text" id="id_cliente" value="<?= $_REQUEST['id_cliente']; ?>" hidden/>
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
                                                    <div class="w-60">
                                                        <div class="d-grid h-100 align-content-center d-none d-md-block">
                                                            Corso
                                                        </div>
                                                    </div>
                                                    <div class="w-40">
                                                        <div class="d-grid h-100 align-content-center">
                                                            Realizato da
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- collapses --><?php 
                                                foreach ($corsi as $key=>$value) {?>
                                                    <div class="accordion mb-2" id="accordionFlushCorso<?= $value['id'];?>">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button collapsed border text-center" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseCorso<?= $value['id'];?>" aria-expanded="false" aria-controls="flush-collapseCorso<?= $value['id'];?>">
                                                                    <div class="w-60">
                                                                        <div class="d-grid h-100 align-content-center fw-bold">
                                                                            <?= strtoupper($value['nome']); ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="w-40">
                                                                        <div class="d-grid h-100 align-content-center">
                                                                            <?= $value['realizzato_da']; ?>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                            </h2>
                                                            <div id="flush-collapseCorso<?= $value['id'];?>" class="accordion-collapse collapse" data-bs-parent="#accordionFlushCorso<?= $value['id'];?>">
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
                                                                        $stato_pagamento = stato_pagamento($v);
                                                                        $abble=in_array($stato_pagamento,['Pendente']);
                                                                        ?>
                                                                        <div 
                                                                            class="d-flex w-100 border p-3 hover <?= $abble?'':'disabled'; ?>" 
                                                                            onclick="window.modalHandlers['percorsi_pendenze'].check(this)"
                                                                            data-id="<?= $v['id'];?>"
                                                                            data-realizzato_da="<?= $v['realizzato_da'];?>"
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
                                                                                    <?= unformat_date($v['scadenza']); ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="w-15">
                                                                                <div class="d-grid h-100 align-content-center prezzo">
                                                                                    <?= number_format($v['prezzo'],2,'.',''); ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="w-15">
                                                                                <div class="d-grid h-100 align-content-center prezzo">
                                                                                    <?= number_format($v['saldato'],2,'.',''); ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="w-15">
                                                                                <div class="d-grid h-100 align-content-center prezzo">
                                                                                    <?= number_format($v['fatturato'],2,'.',''); ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="w-15">
                                                                                <div class="d-grid h-100 align-content-center prezzo">
                                                                                    <?= number_format($v['non_fatturato'],2,'.',''); ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="w-20 d-none d-md-block">
                                                                                <div class="d-grid h-100 align-content-center">
                                                                                    <?= $stato_pagamento; ?>
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
                                                    <div class="w-md-20">
                                                        <div class="d-grid h-100 align-content-center">
                                                            Percorso
                                                        </div>
                                                    </div>
                                                    <div class="w-10 d-none d-md-block">
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
                                                    <div class="w-30">
                                                        <div class="d-grid h-100 align-content-center">
                                                            Realizato da
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- collapses --><?php 
                                                foreach ($trattamenti as $key => $value) {?>

                                                    <div class="d-flex w-100 mb-2">
                                                        <div class="accordion w-100 mt-1 px-0" id="accordionFlush<?= $value['id'];?>">
                                                            <div class="accordion-item px-0">
                                                                <h2 class="accordion-header">
                                                                <button class="accordion-button collapsed text-center" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $value['id'];?>" aria-expanded="false" aria-controls="flush-collapse<?= $value['id'];?>">
                                                                    <div class="d-flex w-100">
                                                                        <div class="w-md-20">
                                                                            <div class="d-grid h-100 align-content-center fw-bold">
                                                                                <?= strtoupper($value['acronimo']);?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-10 d-none d-md-block">
                                                                            <div class="d-grid h-100 align-content-center">
                                                                                <?= number_format($value['prezzo_tabellare'], 2, '.', ''); ?>
                                                                            </div>                                    
                                                                        </div>
                                                                        <div class="w-10">
                                                                            <div class="d-grid h-100 align-content-center">
                                                                                <?= number_format($value['prezzo'], 2, '.', ''); ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-10 d-none d-md-block">
                                                                            <div class="d-grid h-100 align-content-center">
                                                                                <?= number_format($value['saldato'], 2, '.', ''); ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-10 d-none d-md-block">
                                                                            <div class="d-grid h-100 align-content-center">
                                                                                <?= number_format($value['fatturato'], 2, '.', ''); ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-10">
                                                                            <div class="d-grid h-100 align-content-center">
                                                                                <?= number_format($value['non_fatturato'], 2, '.', ''); ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-30">
                                                                            <div class="d-grid h-100 align-content-center">
                                                                                <?= $value['realizzato_da']; ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                                </h2>
                                                                <div id="flush-collapse<?= $value['id'];?>" class="accordion-collapse collapse" data-bs-parent="#accordionFlush<?= $value['id'];?>">
                                                                    <div class="accordion-body text-center">

                                                                        <!-- titles -->
                                                                        <div class="d-flex w-100 px-3 mb-2">
                                                                            <div class="w-5">
                                                                                <div class="d-grid h-100 align-content-center">
                                                                                    #
                                                                                </div>
                                                                            </div>
                                                                            <div class="w-15">
                                                                                <div class="d-grid h-100 align-content-center">
                                                                                    Seduta
                                                                                </div>
                                                                            </div>
                                                                            <div class="w-15">
                                                                                <div class="d-grid h-100 align-content-center d-none d-md-block">
                                                                                    Scadenza
                                                                                </div>
                                                                                <div class="d-grid h-100 align-content-center d-block d-md-none">
                                                                                    N.
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
                                                                            <div class="w-md-15">
                                                                                <div class="d-grid h-100 align-content-center">
                                                                                    Stato Seduta
                                                                                </div>
                                                                            </div>
                                                                            <div class="w-20 d-none d-md-block">
                                                                                <div class="d-grid h-100 align-content-center">
                                                                                    Stato Pagamento
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <!-- sedute --><?php
                                                                        foreach (_view_sedute($value['id']) as $v) {
                                                                            
                                                                            $stato_pagamento = stato_pagamento($v);
                                                                            $abble=in_array($stato_pagamento,['Pendente']);
                                                                            ?>
                                                                            <div 
                                                                                class="d-flex w-100 border p-3 hover <?= $abble?'':'disabled'; ?> <?= $stato_pagamento;?>" 
                                                                                onclick="window.modalHandlers['percorsi_pendenze'].check(this)"
                                                                                data-id="<?= $v['id'];?>"
                                                                                data-realizzato_da="<?= $v['realizzato_da'];?>"
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
                                                                                <div class="w-15">
                                                                                    <div class="d-grid h-100 align-content-center">
                                                                                        <?= $v['index']; ?>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="w-15">
                                                                                    <div class="d-grid h-100 align-content-center">
                                                                                        <?= unformat_date($v['data_seduta']); ?>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="w-15">
                                                                                    <div class="d-grid h-100 align-content-center prezzo">
                                                                                        <?= number_format($v['prezzo'],2,'.',''); ?>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="w-15">
                                                                                    <div class="d-grid h-100 align-content-center prezzo">
                                                                                        <?= number_format($v['saldato'],2,'.',''); ?>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="w-md-15">
                                                                                    <div class="d-grid h-100 align-content-center">
                                                                                        <?= $v['stato_seduta']; ?>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="w-20 d-none d-md-block">
                                                                                    <div class="d-grid h-100 align-content-center">
                                                                                        <?= $stato_pagamento; ?>
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
                        <?= icon('x.svg','black',20,20); ?>
                    </div>
                    <div class="d-grid justify-content-center align-items-center">
                        Rimuovi Selezione
                    </div>
                </div>
            </div>
            <div class="d-flex me-1 mt-1 w-md-33" onclick="window.modalHandlers['percorsi_pendenze'].changePrice(<?= $_REQUEST['id_cliente'];?>)">
                <div class="d-flex flex-row btn btn-light flex-fill">
                    <div class="d-grid justify-content-center align-items-center me-1">
                        <?= icon('edit.svg','black',20,20); ?>
                    </div>
                    <div class="d-grid justify-content-center align-items-center">
                        Modifica prezzo
                    </div>
                </div>
            </div>
            <div class="d-flex me-1 mt-1 flex-fill" onclick="window.modalHandlers['percorsi_pendenze'].del(<?= $_REQUEST['id_cliente'];?>)">
                <div class="d-flex flex-row btn btn-light flex-fill">
                    <div class="d-grid justify-content-center align-items-center me-1">
                        <?= icon('bin.svg','black',20,20); ?>
                    </div>
                    <div class="d-grid justify-content-center align-items-center">
                        Elimina Selezione
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex w-100 flex-wrap">
            <div class= "d-flex me-1 mt-1 w-md-25" 
                onclick="window.modalHandlers['percorsi_pendenze'].fatturaClick();">
                <div class="d-flex flex-row btn btn-primary flex-fill">
                    <div class="d-grid justify-content-center align-items-center me-1">
                        <?= icon('document.svg','white',20,20); ?>
                    </div>
                    <div class="d-grid justify-content-center align-items-center">
                        Fattura D.Z.
                    </div>
                </div>
            </div>
            <div class= "d-flex me-1 mt-1 w-md-25" onclick="window.modalHandlers['percorsi_pendenze'].arubaClick(<?= $_REQUEST['id_cliente'];?>);">
                <div class="d-flex flex-row btn btn-primary flex-fill">
                    <div class="d-grid justify-content-center align-items-center me-1">
                        <?= icon('document.svg','white',20,20); ?>
                    </div>
                    <div class="d-grid justify-content-center align-items-center">
                        Fatturato Aruba
                    </div>
                </div>
            </div>
            <div class= "d-flex me-1 mt-1 w-md-25" onclick="window.modalHandlers['percorsi_pendenze'].isicoClick(<?= $_REQUEST['id_cliente'];?>);">
                <div class="d-flex flex-row btn btn-primary flex-fill">
                    <div class="d-grid justify-content-center align-items-center me-1">
                        <?= icon('document.svg','white',20,20); ?>
                    </div>
                    <div class="d-grid justify-content-center align-items-center">
                        Fatturato Isico
                    </div>
                </div>
            </div>
            <div class= "d-flex me-1 mt-1 flex-fill" onclick="window.modalHandlers['percorsi_pendenze'].senzaFatturaClick(<?= $_REQUEST['id_cliente'];?>);">
                <div class="d-flex flex-row btn btn-primary flex-fill">
                    <div class="d-grid justify-content-center align-items-center me-1">
                        <?= icon('coin.svg','white',20,20); ?>
                    </div>
                    <div class="d-grid justify-content-center align-items-center">
                        Contanti
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="w-100 d-flex d-row mt-2 p-2">
                <div class="m-auto">
                    <div class="d-flex flex-row" style="color:white;font-size:20px">
                        <div class="me-1">Totale Selezionato:</div>
                        <div class="fw-bold" id="sum-selected">0</div>
                    </div>
                    <div class="d-flex flex-row" style="color:white;font-size:20px">
                        <div class="me-1">Sedute Selezionate:</div>
                        <div class="fw-bold" id="count-selected">0</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="json/object" id="data_cliente">
    <?= json_encode(_cliente()); ?>
</script>

<div id="pagamenti_child"></div>
<div id="fattura"></div>
<div id="percorso_combo"></div>
<div id="prezzo_corso"></div>
<div id="percorsi_modifica_prezzo"></div>
<?php module_script('fattura'); ?>
<?php modal_script('percorsi_pendenze'); ?>