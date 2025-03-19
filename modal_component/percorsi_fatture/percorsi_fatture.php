<?php 
    style('modal_component/percorsi_fatture/percorsi_fatture.css');
    $fatture=Select('*')->from('view_fatture')->where("id_cliente={$_REQUEST['id_cliente']}")->get_or_false();
    $senza_fattura=Select('*')->from('pagamenti_senza_fattura')->where("id_cliente={$_REQUEST['id_cliente']}")->get_or_false();
    $aruba=Select('*')->from('pagamenti_aruba')->where("id_cliente={$_REQUEST['id_cliente']}")->get_or_false();
?>
<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Pagamenti</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-span="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" id="id_cliente" value="<?php echo $_REQUEST['id_cliente']; ?>" hidden/>
                <div class="p-2">
                    <div class="container-fluid text-center py-4">
                        <?php if(!$fatture&&!$senza_fattura&&!$aruba){?>
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
                                                    <div class="cc2 d-flex align-items-center justify-content-center text-center">
                                                        <span class="">Fattura</span>
                                                    </div>
                                                    <div class="cc2 d-flex align-items-center justify-content-center text-center">
                                                        <span class="d-none d-md-block">Importo</span>
                                                        <span class="d-md-none">$</span>
                                                    </div>
                                                    <div class="cc1 d-none d-md-flex align-items-center justify-content-center text-center">
                                                        <span class="">Nr.</span>
                                                    </div>
                                                    <div class="cc2 d-none d-md-flex align-items-center justify-content-center text-center">
                                                        <span class="">Emissione</span>
                                                    </div>
                                                    <div class="cc2 d-none d-md-flex align-items-center justify-content-center text-center">
                                                        <span class="">Pagamento</span>
                                                    </div>
                                                    <div class="cc4 d-flex align-items-center justify-content-center text-center">
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
                                                        <div class="cc2 d-flex align-items-center justify-content-center text-center"
                                                                onmouseenter="window.modalHandlers['percorsi_fatture'].enterRow(this)"
                                                                onmouseleave="window.modalHandlers['percorsi_fatture'].leaveRow(this)"
                                                                onclick="window.modalHandlers['percorsi_fatture'].clickRow(this,<?php echo $fattura['id'];?>)"             
                                                            >
                                                            <span><a id="link" href="<?php echo fatture_path($fattura['link']);?>" target="_blank"><?php echo $fattura['index'].".pdf";?></a></span>
                                                        </div>
                                                        <div class="cc2 d-flex align-items-center justify-content-center text-center"
                                                                onmouseenter="window.modalHandlers['percorsi_fatture'].enterRow(this)"
                                                                onmouseleave="window.modalHandlers['percorsi_fatture'].leaveRow(this)"
                                                                onclick="window.modalHandlers['percorsi_fatture'].clickRow(this,<?php echo $fattura['id'];?>)"             
                                                            >
                                                            <span><?php echo $fattura['importo'];?></span>
                                                        </div>
                                                        <div class="cc1 d-none d-md-flex align-items-center justify-content-center text-center"
                                                                onmouseenter="window.modalHandlers['percorsi_fatture'].enterRow(this)"
                                                                onmouseleave="window.modalHandlers['percorsi_fatture'].leaveRow(this)"
                                                                onclick="window.modalHandlers['percorsi_fatture'].clickRow(this,<?php echo $fattura['id'];?>)"             
                                                            >
                                                            <span><?php echo $fattura['index'];?></span>
                                                        </div>
                                                        <div class="cc2 d-none d-md-flex align-items-center justify-content-center text-center"
                                                                onmouseenter="window.modalHandlers['percorsi_fatture'].enterRow(this)"
                                                                onmouseleave="window.modalHandlers['percorsi_fatture'].leaveRow(this)"
                                                                onclick="window.modalHandlers['percorsi_fatture'].clickRow(this,<?php echo $fattura['id'];?>)"             
                                                            >
                                                            <span><?php echo unformat_date($fattura['timestamp']);?></span>
                                                        </div>
                                                        <div class="cc2 d-none d-md-flex align-items-center justify-content-center text-center"
                                                                onmouseenter="window.modalHandlers['percorsi_fatture'].enterRow(this)"
                                                                onmouseleave="window.modalHandlers['percorsi_fatture'].leaveRow(this)"
                                                                onclick="window.modalHandlers['percorsi_fatture'].clickRow(this,<?php echo $fattura['id'];?>)"             
                                                            >
                                                            <span><?php echo $fattura['data']?unformat_date($fattura['data']):'-';?></span>
                                                        </div>
                                                        <div class="cc4 d-flex align-items-center justify-content-center text-center">
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
                                <div class="card mb-3">
                                    <div class="card-header">Senza Fattura</div>
                                    <div class="card-body">
                                        <div class="table-responsive title">
                                            <div class="my-0">
                                                <div class="flex-row titles w-100 d-flex fattura_row">
                                                    <div class="cc2 d-none d-md-flex align-items-center justify-content-center text-center">
                                                        <span class="">Note</span>
                                                    </div>
                                                    <div class="cc2 d-flex align-items-center justify-content-center text-center">
                                                        <span class="d-none d-md-block">Importo</span>
                                                        <span class="d-md-none">$</span>
                                                    </div>
                                                    <div class="cc2 d-none d-md-flex align-items-center justify-content-center text-center">
                                                        <span class="">Emissione</span>
                                                    </div>
                                                    <div class="cc2 d-none d-md-flex align-items-center justify-content-center text-center">
                                                        <span class="">Pagamento</span>
                                                    </div>
                                                    <div class="cc4 d-flex align-items-center justify-content-center text-center">
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
                                                        <div class="cc2 d-none d-md-flex align-items-center justify-content-center text-center">
                                                            <span><?php echo $senza['note'];?></span>
                                                        </div>
                                                        <div class="cc2 d-flex align-items-center justify-content-center text-center">
                                                            <span><?php echo $senza['valore'];?></span>
                                                        </div>
                                                        <div class="cc2 d-none d-md-flex align-items-center justify-content-center text-center"        >
                                                            <span><?php echo unformat_date($senza['timestamp']);?></span>
                                                        </div>
                                                        <div class="cc2 d-none d-md-flex align-items-center justify-content-center text-center"        >
                                                            <span><?php echo $senza['data']?unformat_date($senza['data']):'-';?></span>
                                                        </div>
                                                        <div class="cc4 d-flex align-items-center justify-content-center text-center"      >
                                                            <span>Saldata</span>
                                                        </div>
                                                        <div class="cc1 d-flex align-items-center justify-content-center text-center"
                                                                onmouseenter="window.modalHandlers['percorsi_fatture'].enterDelete(this)"
                                                                onmouseleave="window.modalHandlers['percorsi_fatture'].leaveDelete(this)"
                                                                onclick="window.modalHandlers['percorsi_fatture'].clickDelete(<?php echo $senza['id'].','.$_REQUEST['id_cliente'].',\'pagamenti_senza_fattura\'';?>)"             
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
                            if($aruba){?>
                                <div class="card">
                                    <div class="card-header">Fatturato Aruba</div>
                                    <div class="card-body">
                                        <div class="table-responsive title">
                                            <div class="my-0">
                                                <div class="flex-row titles w-100 d-flex fattura_row">
                                                    <div class="cc2 d-none d-md-flex align-items-center justify-content-center text-center">
                                                        <span class="">Note</span>
                                                    </div>
                                                    <div class="cc2 d-flex align-items-center justify-content-center text-center">
                                                        <span class="d-none d-md-block">Importo</span>
                                                        <span class="d-md-none">$</span>
                                                    </div>
                                                    <div class="cc2 d-none d-md-flex align-items-center justify-content-center text-center">
                                                        <span class="">Emissione</span>
                                                    </div>
                                                    <div class="cc2 d-none d-md-flex align-items-center justify-content-center text-center">
                                                        <span class="">Pagamento</span>
                                                    </div>
                                                    <div class="cc4 d-flex align-items-center justify-content-center text-center">
                                                        <span class="">Stato</span>
                                                    </div>
                                                    <div class="cc1 d-flex align-items-center justify-content-center text-center">
                                                        <span class="">#</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php foreach ($aruba as $a) {?>
                                            <div class="table-responsive">
                                                <div class="my-0">
                                                    <div class="flex-row titles w-100 d-flex fattura_row" >
                                                        <div class="cc2 d-none d-md-flex align-items-center justify-content-center text-center">
                                                            <span><?php echo $a['note'];?></span>
                                                        </div>
                                                        <div class="cc2 d-flex align-items-center justify-content-center text-center">
                                                            <span><?php echo $a['valore'];?></span>
                                                        </div>
                                                        <div class="cc2 d-none d-md-flex align-items-center justify-content-center text-center"        >
                                                            <span><?php echo unformat_date($a['timestamp']);?></span>
                                                        </div>
                                                        <div class="cc2 d-none d-md-flex align-items-center justify-content-center text-center"        >
                                                            <span><?php echo $a['data']?unformat_date($a['data']):'-';?></span>
                                                        </div>
                                                        <div class="cc4 d-flex align-items-center justify-content-center text-center"      >
                                                            <span>Saldata</span>
                                                        </div>
                                                        <div class="cc1 d-flex align-items-center justify-content-center text-center"
                                                                onmouseenter="window.modalHandlers['percorsi_fatture'].enterDelete(this)"
                                                                onmouseleave="window.modalHandlers['percorsi_fatture'].leaveDelete(this)"
                                                                onclick="window.modalHandlers['percorsi_fatture'].clickDelete(<?php echo $a['id'].','.$_REQUEST['id_cliente'].',\'pagamenti_aruba\'';?>)"             
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