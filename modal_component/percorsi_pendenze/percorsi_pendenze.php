<?php 
    function _trattamenti(){
        return Select('id_origine,nome')
        ->from('view_pagamenti')
        ->where("id_cliente={$_REQUEST['id_cliente']} AND saldato < prezzo AND origine='trattamenti'")
        ->groupby('id_origine,nome')
        ->get_or_false();
    }
    function _trattamento($id_origine){
        return Select('*')
        ->from('view_pagamenti')
        ->where("id_cliente={$_REQUEST['id_cliente']} AND saldato < prezzo AND origine='trattamenti' AND id_origine={$id_origine}")
        ->get_or_false();
    }
    function _corsi(){
        return Select('id_origine,nome')
        ->from('view_pagamenti')
        ->where("id_cliente={$_REQUEST['id_cliente']} AND saldato < prezzo AND origine='corsi'")
        ->groupby('id_origine,nome')
        ->get_or_false();
    }
    function _corso($id_origine){
        return Select('*')
        ->from('view_pagamenti')
        ->where("id_cliente={$_REQUEST['id_cliente']} AND saldato < prezzo AND origine='corsi' AND id_origine={$id_origine}")
        ->get_or_false();
    }
    function _cliente(){
        return Select('*')->from('clienti')->where("id={$_REQUEST['id_cliente']}")->first_or_false();
    }
    style('modal_component/percorsi_pendenze/percorsi_pendenze.css');
    $_trattamenti=_trattamenti();
    $_corsi=_corsi();
    $cliente=_cliente();
    $is_first=true;
?>
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
                    <div class="text-end"><h6 class="d-none" id="sum-selected"></h6></div>
                    <div class="container-fluid card text-center py-4">
                        <?php if(!$_trattamenti&&!$_corsi){?>
                            <div class="card">
                                <div class="card-body">
                                    <span>Non ci sono percorsi pendenti per questo cliente.</span>
                                </div>
                            </div><?php
                        }
                        else{ 
                            if($_trattamenti){
                                foreach ($_trattamenti as $trattamenti) {?>
                                    <div class="accordion mb-1" id="trattamenti_<?php echo $trattamenti['id_origine'];?>">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_trattamenti_<?php echo $trattamenti['id_origine'];?>" aria-expanded="false" aria-controls="collapse_trattamenti_<?php echo $trattamenti['id_origine'];?>">
                                                    <?php echo "<b>[TRATTAMENTO]</b>&nbsp{$trattamenti['nome']}";?>
                                                </button>
                                            </h2>
                                            <div id="collapse_trattamenti_<?php echo $trattamenti['id_origine'];?>" class="accordion-collapse collapse" data-bs-parent="#trattamenti_<?php echo $trattamenti['id_origine'];?>">
                                                <div class="table-responsive title">
                                                    <div class="my-0">
                                                        <div class="flex-row titles w-100 d-flex fattura_row">
                                                            <div class="cc1 d-flex align-items-center justify-content-center text-center">
                                                                <span class="">#</span>
                                                            </div>
                                                            <div class="cc4 d-flex align-items-center justify-content-center text-center">
                                                                <span class="d-none d-md-block">Scadenza</span>
                                                                <span class="d-md-none">Scadenza</span>
                                                            </div>
                                                            <div class="cc4 d-none d-md-flex align-items-center justify-content-center text-center">
                                                                <span class="">Tabellare</span>
                                                            </div>
                                                            <div class="cc4 d-flex align-items-center justify-content-center text-center">
                                                                <span class="d-none d-md-block">Prezzo</span>
                                                                <span class="d-md-none">Imp.</span>
                                                            </div>
                                                            <div class="cc4 d-flex align-items-center justify-content-center text-center">
                                                                <span class="d-none d-md-block">Saldato</span>
                                                                <span class="d-md-none">Sald.</span>
                                                            </div>
                                                            <div class="cc4 d-flex align-items-center justify-content-center text-center">
                                                                <span class="d-none d-md-block">Fatturato</span>
                                                                <span class="d-md-none">Fat.</span>
                                                            </div>
                                                            <div class="cc4 d-flex align-items-center justify-content-center text-center">
                                                                <span class="d-none d-md-block">Non Fatturato</span>
                                                                <span class="d-md-none">N.Fat.</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php foreach (_trattamento($trattamenti['id_origine']) as $trattamento) {?>
                                                    <div class="table-responsive">
                                                        <div class="my-0">
                                                            <div class="flex-row titles w-100 d-flex fattura_row <?php echo (int)$trattamento['non_fatturato']==0?'disabled bg-light':''; ?>" origine="trattamenti">
                                                                <input type="hidden" id="trattamento" value="<?php echo $trattamento['nome'];?>"/>
                                                                <div class="cc1 d-flex align-items-center justify-content-center text-center">
                                                                    <input class="form-check-input" type="checkbox" id="id_percorso" origine="trattamenti" value="<?php echo $trattamento['id'];?>" disabled/>
                                                                </div>
                                                                <div class="cc4 d-flex align-items-center justify-content-center text-center"
                                                                        onmouseenter="window.modalHandlers['percorsi_pendenze'].enterRow(this)"
                                                                        onmouseleave="window.modalHandlers['percorsi_pendenze'].leaveRow(this)"
                                                                        onclick="window.modalHandlers['percorsi_pendenze'].clickRow(this)"             
                                                                    >
                                                                    <span id="scadenza" class="d-none d-md-block"><?php echo unformat_date($trattamento['scadenza']);?></span>
                                                                    <span id="scadenza" class="d-md-none"><?php echo format($trattamento['scadenza'],'d/m');?></span>
                                                                </div>
                                                                <div class="cc4 d-none d-md-flex align-items-center justify-content-center text-center"
                                                                        onmouseenter="window.modalHandlers['percorsi_pendenze'].enterRow(this)"
                                                                        onmouseleave="window.modalHandlers['percorsi_pendenze'].leaveRow(this)"
                                                                        onclick="window.modalHandlers['percorsi_pendenze'].clickRow(this)"
                                                                    >
                                                                    <span class=""><?php echo $trattamento['prezzo_tabellare'];?></span>
                                                                </div>
                                                                <div class="cc4 d-flex align-items-center justify-content-center text-center"
                                                                        onmouseenter="window.modalHandlers['percorsi_pendenze'].enterPrezzo(this)"
                                                                        onmouseleave="window.modalHandlers['percorsi_pendenze'].leavePrezzo(this)"
                                                                        onclick="window.modalHandlers['percorsi_pendenze'].clickPrezzoTrattamenti(<?php echo $trattamento['id'].','.$trattamento['id_cliente']; ?>)"
                                                                    >
                                                                    <span id="prezzo"><?php echo $trattamento['prezzo'];?></span>
                                                                </div>
                                                                <div class="cc4 d-flex align-items-center justify-content-center text-center"
                                                                        onmouseenter="window.modalHandlers['percorsi_pendenze'].enterRow(this)"
                                                                        onmouseleave="window.modalHandlers['percorsi_pendenze'].leaveRow(this)"
                                                                        onclick="window.modalHandlers['percorsi_pendenze'].clickRow(this)"
                                                                    >
                                                                    <span id="saldato"><?php echo $trattamento['saldato'];?></span>
                                                                </div>
                                                                <div class="cc4 d-flex align-items-center justify-content-center text-center"
                                                                        onmouseenter="window.modalHandlers['percorsi_pendenze'].enterRow(this)"
                                                                        onmouseleave="window.modalHandlers['percorsi_pendenze'].leaveRow(this)"
                                                                        onclick="window.modalHandlers['percorsi_pendenze'].clickRow(this)"
                                                                    >
                                                                    <span id="fatturato"><?php echo $trattamento['fatturato'];?></span>
                                                                </div>
                                                                <div class="cc4 d-flex align-items-center justify-content-center text-center <?php echo (int)$trattamento['non_fatturato']>0?'bg-warning':0;?>"
                                                                        onmouseenter="window.modalHandlers['percorsi_pendenze'].enterRow(this)"
                                                                        onmouseleave="window.modalHandlers['percorsi_pendenze'].leaveRow(this)"
                                                                        onclick="window.modalHandlers['percorsi_pendenze'].clickRow(this)"
                                                                    >
                                                                    <span id="non_fatturato"><?php echo $trattamento['non_fatturato'];?></span>
                                                                </div>                                           
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="psm"><?php
                                                }?>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="psm"><?php 
                                }
                            }
                            if($_corsi){
                                foreach ($_corsi as $corsi) {?>
                                    <div class="accordion" id="corso_<?php echo $corsi['id_origine'];?>">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_<?php echo $corsi['id_origine'];?>" aria-expanded="false" aria-controls="collapse_<?php echo $corsi['id_origine'];?>">
                                                    <?php echo "<b>[CORSO]</b>&nbsp{$corsi['nome']}"; ?>
                                                </button>
                                            </h2>
                                            <div id="collapse_<?php echo $corsi['id_origine'];?>" class="accordion-collapse collapse" data-bs-parent="#corso_<?php echo $corsi['id_origine'];?>">
                                                <div class="table-responsive title">
                                                    <div class="my-0">
                                                        <div class="flex-row titles w-100 d-flex fattura_row">
                                                            <div class="cc1 d-flex align-items-center justify-content-center text-center">
                                                                <span class="">#</span>
                                                            </div>
                                                            <div class="cc4 d-flex align-items-center justify-content-center text-center">
                                                                <span class="d-none d-md-block">Scadenza</span>
                                                                <span class="d-md-none">Scadenza</span>
                                                            </div>
                                                            <div class="cc4 d-none d-md-flex align-items-center justify-content-center text-center">
                                                                <span class="">Tabellare</span>
                                                            </div>
                                                            <div class="cc4 d-flex align-items-center justify-content-center text-center">
                                                                <span class="d-none d-md-block">Prezzo</span>
                                                                <span class="d-md-none">Imp.</span>
                                                            </div>
                                                            <div class="cc4 d-flex align-items-center justify-content-center text-center">
                                                                <span class="d-none d-md-block">Saldato</span>
                                                                <span class="d-md-none">Sald.</span>
                                                            </div>
                                                            <div class="cc4 d-flex align-items-center justify-content-center text-center">
                                                                <span class="d-none d-md-block">Fatturato</span>
                                                                <span class="d-md-none">Fat.</span>
                                                            </div>
                                                            <div class="cc4 d-flex align-items-center justify-content-center text-center">
                                                                <span class="d-none d-md-block">Non Fatturato</span>
                                                                <span class="d-md-none">N.Fat.</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><?php
                                                foreach(_corso($corsi['id_origine']) as $corso){?>
                                                    <div class="table-responsive">
                                                        <div class="my-0">
                                                            <div class="flex-row titles w-100 d-flex fattura_row <?php echo (int)$corso['non_fatturato']==0?'disabled bg-light':''; ?>" origine="corsi">
                                                                <input type="hidden" id="trattamento" value="<?php echo $corso['nome'];?>"/>
                                                                <div class="cc1 d-flex align-items-center justify-content-center text-center">
                                                                    <input class="form-check-input" type="checkbox" id="id_percorso" origine="corsi" value="<?php echo $corso['id'];?>" disabled/>
                                                                </div>
                                                                <div class="cc4 d-flex align-items-center justify-content-center text-center"
                                                                        onmouseenter="window.modalHandlers['percorsi_pendenze'].enterRow(this)"
                                                                        onmouseleave="window.modalHandlers['percorsi_pendenze'].leaveRow(this)"
                                                                        onclick="window.modalHandlers['percorsi_pendenze'].clickRow(this)"             
                                                                    >
                                                                    <span id="scadenza" class="d-none d-md-block"><?php echo unformat_date($corso['scadenza']);?></span>
                                                                    <span id="scadenza" class="d-md-none"><?php echo format($corso['scadenza'],'d/m');?></span>
                                                                </div>
                                                                <div class="cc4 d-none d-md-flex align-items-center justify-content-center text-center"
                                                                        onmouseenter="window.modalHandlers['percorsi_pendenze'].enterRow(this)"
                                                                        onmouseleave="window.modalHandlers['percorsi_pendenze'].leaveRow(this)"
                                                                        onclick="window.modalHandlers['percorsi_pendenze'].clickRow(this)"
                                                                    >
                                                                    <span class=""><?php echo $corso['prezzo_tabellare'];?></span>
                                                                </div>
                                                                <div class="cc4 d-flex align-items-center justify-content-center text-center"
                                                                        onmouseenter="window.modalHandlers['percorsi_pendenze'].enterPrezzo(this)"
                                                                        onmouseleave="window.modalHandlers['percorsi_pendenze'].leavePrezzo(this)"
                                                                        onclick="window.modalHandlers['percorsi_pendenze'].clickPrezzoCorsi(<?php echo $corso['id'].','.$corso['prezzo_tabellare'].','.$corso['prezzo'].','.$corso['id_cliente']; ?>)"
                                                                    >
                                                                    <span id="prezzo"><?php echo $corso['prezzo'];?></span>
                                                                </div>
                                                                <div class="cc4 d-flex align-items-center justify-content-center text-center"
                                                                        onmouseenter="window.modalHandlers['percorsi_pendenze'].enterRow(this)"
                                                                        onmouseleave="window.modalHandlers['percorsi_pendenze'].leaveRow(this)"
                                                                        onclick="window.modalHandlers['percorsi_pendenze'].clickRow(this)"
                                                                    >
                                                                    <span id="saldato"><?php echo $corso['saldato'];?></span>
                                                                </div>
                                                                <div class="cc4 d-flex align-items-center justify-content-center text-center"
                                                                        onmouseenter="window.modalHandlers['percorsi_pendenze'].enterRow(this)"
                                                                        onmouseleave="window.modalHandlers['percorsi_pendenze'].leaveRow(this)"
                                                                        onclick="window.modalHandlers['percorsi_pendenze'].clickRow(this)"
                                                                    >
                                                                    <span id="fatturato"><?php echo $corso['fatturato'];?></span>
                                                                </div>
                                                                <div class="cc4 d-flex align-items-center justify-content-center text-center <?php echo (int)$corso['non_fatturato']>0?'bg-warning':0;?>"
                                                                        onmouseenter="window.modalHandlers['percorsi_pendenze'].enterRow(this)"
                                                                        onmouseleave="window.modalHandlers['percorsi_pendenze'].leaveRow(this)"
                                                                        onclick="window.modalHandlers['percorsi_pendenze'].clickRow(this)"
                                                                    >
                                                                    <span id="non_fatturato"><?php echo $corso['non_fatturato'];?></span>
                                                                </div>                                           
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="psm"><?php
                                                }?>
                                            </div>
                                        </div>
                                    </div>                                
                                    <p class="psm"><?php
                                }
                            }?>
                            <div class="d-flex flex-fill mt-1">
                                <div class= "d-flex flex-fill" 
                                    data-id-nominativo="<?php echo $cliente['nominativo'];?>"
                                    data-id-indirizzo="<?php echo $cliente['indirizzo'];?>"
                                    data-id-cap="<?php echo $cliente['cap'];?>"
                                    data-id-citta="<?php echo $cliente['citta'];?>"
                                    data-id-cf="<?php echo $cliente['cf'];?>"
                                    onclick="window.modalHandlers['percorsi_pendenze'].fatturaClick(this,<?php echo $_REQUEST['id_cliente'];?>);">
                                    <button type="button" class="btn btn-primary p-2 d-flex flex-fill btn-insert h-100">
                                        <div class="mx-2"><?php echo icon('document.svg','white',20,17);?></div>
                                        <div>Fattura</div>
                                    </button>
                                </div>
                                <div class= "d-flex flex-fill ms-1" onclick="window.modalHandlers['percorsi_pendenze'].arubaClick(this,<?php echo $_REQUEST['id_cliente'];?>);">
                                    <button type="button" class="btn btn-primary p-2 d-flex flex-fill btn-insert w-100 h-100">
                                        <div class="mx-2"><?php echo icon('bill-check.svg','white',20,25);?></div>
                                        <div class="d-none d-md-block">Fatturato Aruba</div>
                                        <div class="d-md-none">Aruba</div>
                                    </button>
                                </div>
                                <div class= "d-flex flex-fill ms-1" onclick="window.modalHandlers['percorsi_pendenze'].senzaFatturaClick(this,<?php echo $_REQUEST['id_cliente'];?>);">
                                    <button type="button" class="btn btn-primary p-2 d-flex flex-fill btn-insert w-100 h-100">
                                        <div class="mx-2"><?php echo icon('coin.svg','white',20,25);?></div>
                                        <div class="d-none d-md-block">Senza Fattura</div>
                                        <div class="d-md-none">S.Fat.</div>
                                    </button>
                                </div>
                            </div><?php
                        }?>
                    </div>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
<div id="fattura"></div>
<div id="senza_fattura"></div>
<div id="fatturato_aruba"></div>
<div id="percorso_terapeutico"></div>
<div id="prezzo_corso"></div>
<?php modal_script('percorsi_pendenze'); ?>