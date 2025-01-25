<?php 
    function _percorso(){
        return Select('*')
        ->from('view_percorsi_pagamenti')
        ->where("id_cliente={$_REQUEST['id_cliente']} AND saldato < prezzo")
        ->get_or_false();
    }
    style('modal_component/percorsi_pagamenti/percorsi_pagamenti.css');
    $_percorso=_percorso();
    $is_first=true;
?>
<div class="modal bg-dark bg-opacity-50" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Pendenze</h4>
                <button type="button" class="btn-resize" aria-hidden="true" onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>                
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="container"></div>
            <div class="modal-body">
                <div class="p-2">
                    <input type="text" id="id_cliente" value="<?php echo $_REQUEST['id_cliente']; ?>" hidden/>
                    <div class="container-fluid card text-center py-4">
                        <?php if(!$_percorso){?>
                            <div class="card">
                                <div class="card-body">
                                    <span>Non ci sono percorsi pendenti per questo cliente.</span>
                                </div>
                            </div><?php
                        }
                        else{ ?>
                            <div class="table-responsive title">
                                <div class="my-0">
                                    <div class="flex-row titles w-100 d-flex fattura_row">
                                        <div class="cc1 d-flex align-items-center justify-content-center text-center">
                                            <span class="">#</span>
                                        </div>
                                        <div class="cc4 d-flex align-items-center justify-content-center text-center">
                                            <span class="">Percorso Terapeutico</span>
                                        </div>
                                        <div class="cc4 d-flex align-items-center justify-content-center text-center">
                                            <span class="">Prezzo Tabellare</span>
                                        </div>
                                        <div class="cc4 d-flex align-items-center justify-content-center text-center">
                                            <span class="">Prezzo</span>
                                        </div>
                                        <div class="cc4 d-flex align-items-center justify-content-center text-center">
                                            <span class="">Saldato</span>
                                        </div>
                                        <div class="cc4 d-flex align-items-center justify-content-center text-center">
                                            <span class="">Fatturato</span>
                                        </div>
                                        <div class="cc4 d-flex align-items-center justify-content-center text-center">
                                            <span class="">Non Fatturato</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="psm"></p>
                            <?php foreach ($_percorso as $percorso) {?>
                                <div class="table-responsive">
                                    <div class="my-0">
                                        <div class="flex-row titles w-100 d-flex fattura_row <?php echo (int)$percorso['non_fatturato']==0?'disabled bg-light':''; ?>">
                                            <div class="cc1 d-flex align-items-center justify-content-center text-center">
                                                <input class="form-check-input" type="checkbox" id="id_percorso" value="<?php echo $percorso['id_percorso'];?>" disabled/>
                                            </div>
                                            <div class="cc4 d-flex align-items-center justify-content-center text-center"
                                                    onmouseenter="window.modalHandlers['percorsi_pagamenti'].enterRow(this)"
                                                    onmouseleave="window.modalHandlers['percorsi_pagamenti'].leaveRow(this)"
                                                    onclick="window.modalHandlers['percorsi_pagamenti'].clickRow(this)"             
                                                >
                                                <span id="trattamento"><?php echo $percorso['trattamento'];?></span>
                                            </div>
                                            <div class="cc4 d-flex align-items-center justify-content-center text-center"
                                                    onmouseenter="window.modalHandlers['percorsi_pagamenti'].enterRow(this)"
                                                    onmouseleave="window.modalHandlers['percorsi_pagamenti'].leaveRow(this)"
                                                    onclick="window.modalHandlers['percorsi_pagamenti'].clickRow(this)"
                                                >
                                                <span class=""><?php echo $percorso['prezzo_tabellare'];?></span>
                                            </div>
                                            <div class="cc4 d-flex align-items-center justify-content-center text-center"
                                                    onmouseenter="window.modalHandlers['percorsi_pagamenti'].enterPrezzo(this)"
                                                    onmouseleave="window.modalHandlers['percorsi_pagamenti'].leavePrezzo(this)"
                                                    onclick="window.modalHandlers['percorsi_pagamenti'].clickPrezzo(<?php echo $percorso['id_percorso'].','.$percorso['id_cliente']; ?>)"
                                                >
                                                <span id="prezzo"><?php echo $percorso['prezzo'];?></span>
                                            </div>
                                            <div class="cc4 d-flex align-items-center justify-content-center text-center"
                                                    onmouseenter="window.modalHandlers['percorsi_pagamenti'].enterRow(this)"
                                                    onmouseleave="window.modalHandlers['percorsi_pagamenti'].leaveRow(this)"
                                                    onclick="window.modalHandlers['percorsi_pagamenti'].clickRow(this)"
                                                >
                                                <span id="saldato"><?php echo $percorso['saldato'];?></span>
                                            </div>
                                            <div class="cc4 d-flex align-items-center justify-content-center text-center"
                                                    onmouseenter="window.modalHandlers['percorsi_pagamenti'].enterRow(this)"
                                                    onmouseleave="window.modalHandlers['percorsi_pagamenti'].leaveRow(this)"
                                                    onclick="window.modalHandlers['percorsi_pagamenti'].clickRow(this)"
                                                >
                                                <span id="fatturato"><?php echo $percorso['fatturato'];?></span>
                                            </div>
                                            <div class="cc4 d-flex align-items-center justify-content-center text-center"
                                                    onmouseenter="window.modalHandlers['percorsi_pagamenti'].enterRow(this)"
                                                    onmouseleave="window.modalHandlers['percorsi_pagamenti'].leaveRow(this)"
                                                    onclick="window.modalHandlers['percorsi_pagamenti'].clickRow(this)"
                                                >
                                                <span id="non_fatturato"><?php echo $percorso['non_fatturato'];?></span>
                                            </div>                                           
                                        </div>
                                    </div>
                                </div>                                
                                <p class="psm"><?php
                            }?>
                            <div class="d-flex flex-fill mt-3">
                            <div class= "d-flex w-50" onclick="window.modalHandlers['percorsi_pagamenti'].fatturaClick(this,<?php echo $_REQUEST['id_cliente'];?>);">
                                <button type="button" class="btn btn-primary p-2 d-flex flex-row btn-insert w-100 h-100">
                                    <div class="mx-2"><?php echo icon('document.svg','white',20,17);?></div>
                                    <div>Fattura</div>
                                </button>
                            </div>
                            <div class= "d-flex flex-fill ms-1" onclick="window.modalHandlers['percorsi_pagamenti'].senzaFatturaClick(this,<?php echo $_REQUEST['id_cliente'];?>);">
                                <button type="button" class="btn btn-primary p-2 d-flex flex-row btn-insert w-100 h-100">
                                    <div class="mx-2"><?php echo icon('coin.svg','white',20,25);?></div>
                                    <div>Senza Fattura</div>
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
<div id="percorso_terapeutico"></div>
<?php modal_script('percorsi_pagamenti'); ?>