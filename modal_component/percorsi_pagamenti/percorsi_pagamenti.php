<?php 
    function _percorso(){
        return Select('*')
        ->from('view_percorsi')
        ->where("id_cliente={$_REQUEST['id_cliente']}")
        ->get_or_false();
    }
    function _fatture($id_percorso){
        return Select('f.*,p.stato,p.id as ppf_id')
            ->from('percorsi_pagamenti_fatture','p')
            ->left_join('fatture f ON p.id_fattura = f.id')
            ->left_join('percorsi_pagamenti pp ON p.id_percorso_pagamenti = pp.id')
            ->where("pp.id_percorso={$id_percorso}")
            ->get();
    }
    style('modal_component/percorsi_pagamenti/percorsi_pagamenti.css');
    $_percorso=_percorso();
    $is_first=true;
?>
<div class="modal bg-dark bg-opacity-50" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Non Fatturati</h4>
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
                                    <span>Non ci sono percorsi per questo cliente.</span>
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
                                            <span class="">Situazione</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="psm"></p>
                            <?php foreach ($_percorso as $percorso) {?>
                                <div class="table-responsive">
                                    <div class="my-0">
                                        <div class="flex-row titles w-100 d-flex fattura_row hover" 
                                            onclick="window.modalHandlers['percorsi_pagamenti'].clickRow(this)"
                                            >
                                            <div class="cc1 d-flex align-items-center justify-content-center text-center">
                                                <input class="form-check-input" type="checkbox" id="id_percorso" value="<?php echo $percorso['id'];?>"/>
                                            </div>
                                            <div class="cc4 d-flex align-items-center justify-content-center text-center">
                                                <span id="trattamento"><?php echo $percorso['trattamento'];?></span>
                                            </div>
                                            <div class="cc4 d-flex align-items-center justify-content-center text-center">
                                                <span class=""><?php echo $percorso['prezzo_tabellare'];?></span>
                                            </div>
                                            <div class="cc4 d-flex align-items-center justify-content-center text-center">
                                                <span id="prezzo"><?php echo $percorso['prezzo'];?></span>
                                            </div>
                                            <div class="cc4 d-flex align-items-center justify-content-center text-center">
                                                <span class=""><?php echo $percorso['stato'];?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                                <p class="psm"><?php
                            }
                        }?>
                        <div class="d-flex flex-fill my-3" onclick="window.modalHandlers['percorsi_pagamenti'].fatturaClick(this,<?php echo $_REQUEST['id_cliente'];?>)"><button class="btn btn-primary flex-fill">Fattura</button></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
<div id="fattura"></div>
<?php modal_script('percorsi_pagamenti'); ?>