<?php 
    function _percorso(){
        return Select('*')
        ->from('pagamenti','p')
        ->where("p.id_cliente={$_REQUEST['id_cliente']}")
        ->orderby('p.timestamp DESC')
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
            <div class="modal-header"><h4 class="modal-title">Percorso Terapeutico</h4>
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
                            <div class="table-responsive">
                                <div class="my-0">
                                    <div class="flex-row titles w-100 d-flex">
                                        <div class="cc2 d-flex align-items-center justify-content-center text-center">
                                            <span class="">Percorso Terapeutico</span>
                                        </div>
                                        <div class="cc4 d-flex align-items-center justify-content-center text-center">
                                            <span class="">Prezzo Tabellare</span>
                                        </div>
                                        <div class="cc3 d-flex align-items-center justify-content-center text-center">
                                            <span class="">Prezzo</span>
                                        </div>
                                        <div class="cc3 d-flex align-items-center justify-content-center text-center">
                                            <span class="">Pendente</span>
                                        </div>
                                        <div class="cc3 d-flex align-items-center justify-content-center text-center">
                                            <span class="">Fatturato</span>
                                        </div>
                                        <div class="cc3 d-flex align-items-center justify-content-center text-center">
                                            <span class="">Saldato</span>
                                        </div>
                                        <div class="cc4 d-flex align-items-center justify-content-center text-center">
                                            <span class="">Situazione</span>
                                        </div>
                                        <div class="cc1 d-flex align-items-center justify-content-center text-center">
                                            <span class="">#</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php foreach ($_percorso as $percorso) {
                                $show = $is_first;$is_first = false;
                                $fatture=_fatture($percorso['id_percorso']);?>
                                <div class="accordion" id="accordion-percorso<?php echo $percorso['id_percorso'];?>">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <div class="accordion-button border py-2 <?php echo $show?'':'collapsed'; ?>" name="row_percorso" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-percorso<?php echo $percorso['id_percorso'];?>" aria-expanded="<?php echo $show; ?>" aria-controls="collapse-percorso<?php echo $percorso['id_percorso'];?>">
                                                <div class="d-flex flex-row w-100 ">
                                                    <input value="<?php echo $percorso['id_percorso'];?>" id="id_percorso" hidden/>
                                                    <div class="cc2 d-flex align-items-center justify-content-center text-center"><span class=""><?php echo $percorso['percorso']; ?></span></div>
                                                    <div class="cc4 d-flex align-items-center justify-content-center text-center"><span class=""><?php echo $percorso['prezzo_tabellare']; ?></span></div>
                                                    <div class="cc3 d-flex align-items-center justify-content-center text-center"><span class=""><?php echo $percorso['prezzo']; ?></span></div>
                                                    <div class="cc3 d-flex align-items-center justify-content-center text-center"><span class=""><?php echo $percorso['Pendente']; ?></span></div>
                                                    <div class="cc3 d-flex align-items-center justify-content-center text-center"><span class=""><?php echo $percorso['fatturato']??0; ?></span></div>
                                                    <div class="cc3 d-flex align-items-center justify-content-center text-center"><span class=""><?php echo $percorso['Saldato']; ?></span></div>
                                                    <div class="cc4 d-flex align-items-center justify-content-center text-center"><span class=""><?php echo $percorso['Pendente']>0?'PENDENTE':'SALDATO'; ?></span></div>
                                                    <div class="cc1 d-flex align-items-center justify-content-center text-center" 
                                                        onclick="window.modalHandlers['percorsi_pagamenti'].aggiungiFattureClick(this,<?php echo $_REQUEST['id_cliente'];?>)" 
                                                        onmouseenter="window.modalHandlers['percorsi_pagamenti'].aggiungiEnter(this)" 
                                                        onmouseleave="window.modalHandlers['percorsi_pagamenti'].aggiungiLeave(this)">
                                                        <button class="btn <?php echo ((int)$percorso['Saldato']+(int)$percorso['fatturato'])<(int)$percorso['prezzo']?'btn-primary':'btn-dark disabled';?>">FATTURA</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </h2>
                                        <div id="collapse-percorso<?php echo $percorso['id_percorso'];?>" class="accordion-collapse collapse <?php echo $show?'show':''; ?>" data-bs-parent="#accordion-percorso<?php echo $percorso['id_percorso'];?>">
                                            <div class="container-fluid card text-center py-4">
                                                <?php if(!$fatture){?>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <span>Non ci sono fatture per questo percorso.</span>
                                                        </div>
                                                    </div><?php
                                                }
                                                else{ ?>
                                                    <div class="table-responsive">
                                                        <div class="my-0">
                                                            <div class="flex-row titles w-100 d-flex border">
                                                                <div class="csp1 d-flex align-items-center justify-content-center text-center">
                                                                    <span class="">Fattura</span>
                                                                </div>
                                                                <div class="csp2 d-flex align-items-center justify-content-center text-center">
                                                                    <span class="">N°</span>
                                                                </div>
                                                                <div class="csp2 d-flex align-items-center justify-content-center text-center">
                                                                    <span class="">Prezzo</span>
                                                                </div>
                                                                <div class="csp2 d-flex align-items-center justify-content-center text-center">
                                                                    <span class="">Stato</span>
                                                                </div>
                                                                <div class="csp2 d-flex align-items-center justify-content-center text-center">
                                                                    <span class="">#</span>
                                                                </div>
                                                            </div><?php
                                                            foreach($fatture as $fattura){?>
                                                                <div class="flex-row titles w-100 d-flex border">
                                                                    <div class="csp1 d-flex align-items-center justify-content-center text-center"><a href="<?php echo url(fatture_path($fattura['link'])); ?>" target="_blank"><?php echo $fattura['link']; ?></a></div>
                                                                    <div class="csp2 d-flex align-items-center justify-content-center text-center"><span class=""><?php echo $fattura['index']; ?></span></div>
                                                                    <div class="csp2 d-flex align-items-center justify-content-center text-center"><span class=""><?php echo $fattura['prezzo']; ?></span></div>
                                                                    <div class="csp2 d-flex align-items-center justify-content-center text-center ">
                                                                        <select type="text" class="form-control  text-center" id="stato" value="<?php echo $fattura['stato']??'';?>" 
                                                                            onchange="window.modalHandlers['percorsi_pagamenti'].changeStato(this.value,<?php echo $fattura['ppf_id'].','.$_REQUEST['id_cliente'];?>)">
                                                                            <?php 
                                                                                foreach(Enum('percorsi_pagamenti_fatture','stato')->list as $value){
                                                                                    $selected = (isset($fattura['stato']) && $fattura['stato'] == $value) ? 'selected' : '';
                                                                                    echo "<option value=\"{$value}\" class=\"ps-4  bg-white\" {$selected}>{$value}</option>";
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="csp2 d-flex align-items-center justify-content-center text-center delHover" 
                                                                        onclick="window.modalHandlers['percorsi_pagamenti'].deleteFattura(this,<?php echo $fattura['id']; ?>)" 
                                                                        onmouseenter="window.modalHandlers['percorsi_pagamenti'].enterFattura(this);" 
                                                                        onmouseleave="window.modalHandlers['percorsi_pagamenti'].leaveFattura(this);">
                                                                        <?php echo icon('bin.svg','black',16,16); ?></div>
                                                                </div><?php
                                                            }?>
                                                        </div>
                                                    </div><?php
                                                }?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="psm"><?php
                            }
                        }?>
                    </div>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
<div id="fattura"></div>
<?php modal_script('percorsi_pagamenti'); ?>