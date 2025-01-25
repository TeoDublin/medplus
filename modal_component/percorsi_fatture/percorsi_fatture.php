<?php 
    style('modal_component/percorsi_fatture/percorsi_fatture.css');
    $fatture=Select('*')->from('view_fatture')->where("id_cliente={$_REQUEST['id_cliente']}")->get_or_false();
    $senza_fattura=Select('*')->from('percorsi_pagamenti_senza_fattura')->where("id_cliente={$_REQUEST['id_cliente']}")->get_or_false();
?>
<div class="modal modal-xxl bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Pagamenti</h4>
                <button type="button" class="btn-resize" aria-hidden="true" onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body overflow-auto flex-grow-1">
                <input type="text" id="id_cliente" value="<?php echo $_REQUEST['id_cliente']; ?>" hidden/>
                <div class="p-2">
                    <div class="container-fluid text-center py-4">
                        <?php if(!$fatture&&!$senza_fattura){?>
                            <div class="card">
                                <div class="card-body">
                                    <span>Non ci fatture per questo cliente.</span>
                                </div>
                            </div><?php
                        }
                        else{ 
                            if($fatture){?>
                                <div class="card mb-3">
                                    <div class="card-header">Fatture</div>
                                    <div class="card-body">
                                        <div class="table-responsive title">
                                            <div class="my-0">
                                                <div class="flex-row titles w-100 d-flex fattura_row">
                                                    <div class="cc4 d-flex align-items-center justify-content-center text-center">
                                                        <span class="">Fattura</span>
                                                    </div>
                                                    <div class="cc2 d-flex align-items-center justify-content-center text-center">
                                                        <span class="">Importo</span>
                                                    </div>
                                                    <div class="cc1 d-flex align-items-center justify-content-center text-center">
                                                        <span class="">Nr.</span>
                                                    </div>
                                                    <div class="cc2 d-flex align-items-center justify-content-center text-center">
                                                        <span class="">Emissione</span>
                                                    </div>
                                                    <div class="cc2 d-flex align-items-center justify-content-center text-center">
                                                        <span class="">Stato</span>
                                                    </div>
                                                    <div class="cc1 d-flex align-items-center justify-content-center text-center">
                                                        <span class="">#</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="psm"></p>
                                        <?php foreach ($fatture as $fattura) {?>
                                            <div class="table-responsive">
                                                <div class="my-0">
                                                    <div class="flex-row titles w-100 d-flex fattura_row" >
                                                        <div class="cc4 d-flex align-items-center justify-content-center text-center"
                                                                onmouseenter="window.modalHandlers['percorsi_fatture'].enterRow(this)"
                                                                onmouseleave="window.modalHandlers['percorsi_fatture'].leaveRow(this)"
                                                                onclick="window.modalHandlers['percorsi_fatture'].clickRow(this,<?php echo $fattura['id'];?>)"             
                                                            >
                                                            <span><a id="link" href="<?php echo fatture_path($fattura['link']);?>" target="_blank"><?php echo $fattura['link'];?></a></span>
                                                        </div>
                                                        <div class="cc2 d-flex align-items-center justify-content-center text-center"
                                                                onmouseenter="window.modalHandlers['percorsi_fatture'].enterRow(this)"
                                                                onmouseleave="window.modalHandlers['percorsi_fatture'].leaveRow(this)"
                                                                onclick="window.modalHandlers['percorsi_fatture'].clickRow(this,<?php echo $fattura['id'];?>)"             
                                                            >
                                                            <span><?php echo $fattura['importo'];?></span>
                                                        </div>
                                                        <div class="cc1 d-flex align-items-center justify-content-center text-center"
                                                                onmouseenter="window.modalHandlers['percorsi_fatture'].enterRow(this)"
                                                                onmouseleave="window.modalHandlers['percorsi_fatture'].leaveRow(this)"
                                                                onclick="window.modalHandlers['percorsi_fatture'].clickRow(this,<?php echo $fattura['id'];?>)"             
                                                            >
                                                            <span><?php echo $fattura['index'];?></span>
                                                        </div>
                                                        <div class="cc2 d-flex align-items-center justify-content-center text-center"
                                                                onmouseenter="window.modalHandlers['percorsi_fatture'].enterRow(this)"
                                                                onmouseleave="window.modalHandlers['percorsi_fatture'].leaveRow(this)"
                                                                onclick="window.modalHandlers['percorsi_fatture'].clickRow(this,<?php echo $fattura['id'];?>)"             
                                                            >
                                                            <span><?php echo unformat_date($fattura['data']);?></span>
                                                        </div>
                                                        <div class="cc2 d-flex align-items-center justify-content-center text-center">
                                                            <?php 
                                                                echo "<select class=\"form-control text-center\" name=\"id_categoria\" value=\"{$fattura['stato']}\"
                                                                    onmouseenter=\"window.modalHandlers['percorsi_fatture'].enterStato(this)\"
                                                                    onmouseleave=\"window.modalHandlers['percorsi_fatture'].leaveStato(this)\"
                                                                    onchange=\"window.modalHandlers['percorsi_fatture'].changeStato(this.value,{$fattura['id']})\"                                                    
                                                                >";
                                                                foreach(Enum('fatture','stato')->list as $enum){
                                                                    $selected=$fattura['stato']==$enum?'selected':'';
                                                                    echo "<option value=\"{$enum}\" {$selected}>{$enum}</option>";
                                                                }
                                                                echo "</select>";
                                                            ?>
                                                        </div>
                                                        <div class="cc1 d-flex align-items-center justify-content-center text-center"
                                                                onmouseenter="window.modalHandlers['percorsi_fatture'].enterDelete(this)"
                                                                onmouseleave="window.modalHandlers['percorsi_fatture'].leaveDelete(this)"
                                                                onclick="window.modalHandlers['percorsi_fatture'].clickDelete(<?php echo $fattura['id'].','.$_REQUEST['id_cliente'].',\'fatture\'';?>)"             
                                                            >
                                                            <span><?php echo icon('bin.svg');?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                
                                            <p class="psm"><?php
                                        }?>
                                    </div>
                                </div><?php
                            }
                            if($senza_fattura){?>
                                <div class="card">
                                    <div class="card-header">Senza Fattura</div>
                                    <div class="card-body">
                                        <div class="table-responsive title">
                                            <div class="my-0">
                                                <div class="flex-row titles w-100 d-flex fattura_row">
                                                    <div class="cc4 d-flex align-items-center justify-content-center text-center">
                                                        <span class="">Note</span>
                                                    </div>
                                                    <div class="cc3 d-flex align-items-center justify-content-center text-center">
                                                        <span class="">Importo</span>
                                                    </div>
                                                    <div class="cc2 d-flex align-items-center justify-content-center text-center">
                                                        <span class="">Emissione</span>
                                                    </div>
                                                    <div class="cc2 d-flex align-items-center justify-content-center text-center">
                                                        <span class="">Stato</span>
                                                    </div>
                                                    <div class="cc1 d-flex align-items-center justify-content-center text-center">
                                                        <span class="">#</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php foreach ($senza_fattura as $senza) {?>
                                            <div class="table-responsive">
                                                <div class="my-0">
                                                    <div class="flex-row titles w-100 d-flex fattura_row" >
                                                        <div class="cc4 d-flex align-items-center justify-content-center text-center">
                                                            <span><?php echo $senza['note'];?></span>
                                                        </div>
                                                        <div class="cc3 d-flex align-items-center justify-content-center text-center">
                                                            <span><?php echo $senza['valore'];?></span>
                                                        </div>
                                                        <div class="cc2 d-flex align-items-center justify-content-center text-center"        >
                                                            <span><?php echo unformat_date($senza['timestamp']);?></span>
                                                        </div>
                                                        <div class="cc2 d-flex align-items-center justify-content-center text-center"      >
                                                            <span>Saldata</span>
                                                        </div>
                                                        <div class="cc1 d-flex align-items-center justify-content-center text-center"
                                                                onmouseenter="window.modalHandlers['percorsi_fatture'].enterDelete(this)"
                                                                onmouseleave="window.modalHandlers['percorsi_fatture'].leaveDelete(this)"
                                                                onclick="window.modalHandlers['percorsi_fatture'].clickDelete(<?php echo $senza['id'].','.$_REQUEST['id_cliente'].',\'percorsi_pagamenti_senza_fattura\'';?>)"             
                                                            >
                                                            <span><?php echo icon('bin.svg');?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                
                                            <p class="psm"><?php
                                        }?>
                                    </div>
                                </div><?php
                            }
                        }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php modal_script('percorsi_fatture'); ?>
</div>