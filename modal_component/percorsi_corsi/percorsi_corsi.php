<?php 
    style('modal_component/percorsi_corsi/percorsi_corsi.css');
    $corsi=Select('*')->from('view_classi')->where("id_cliente={$_REQUEST['id_cliente']}")->get_or_false();
?>
<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Corsi</h4>
                <button type="button" class="btn-resize" aria-hidden="true" onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-span="Close"></button>
            </div>
            <div class="modal-body"><?php
                if(!$corsi){?>
                    <div class="card">
                        <div class="card-body">
                            <span>Non ci corsi per questo cliente.</span>
                        </div>
                    </div><?php
                }
                else{?>
                <div class="card">
                    <div class="card-body">
                        <div class="container-fluid text-center">
                            <div class="table-responsive">
                                <div class="d-flex flex-row w-100 mb-2">
                                    <div class="flex-fill"><span>Corso</span></div>
                                    <div class="w-30"><span>Terapista</span></div>
                                    <div class="d-none d-md-block w-20"><span>Inizio</span></div>
                                    <div class="d-none d-md-block w-20"><span>Prezzo Tabellare</span></div>
                                    <div class="w-20"><span>Prezzo</span></div>
                                    <div class="w-10 last"><span>#</span></div>
                                </div>
                            </div><?php
                            foreach ($corsi as $corso) {?>
                                <div class="table-responsive">
                                    <div class="d-flex flex-row percorsi-row w-100 mb-2">
                                        <div class="flex-fill"><span><?php echo $corso['corso']; ?></span></div>
                                        <div class="w-30"><span><?php echo $corso['terapista']; ?></span></div>
                                        <div class="d-none d-md-block w-20"><span><?php echo unformat_date($corso['data_inizio']); ?></span></div>
                                        <div class="d-none d-md-block w-20"><span><?php echo $corso['prezzo_tabellare']; ?></span></div>
                                        <div class="w-20"><span><?php echo $corso['prezzo']; ?></span></div>
                                        <div class="w-10 last"
                                            onmouseenter="window.modalHandlers['percorsi_corsi'].delEnter(this)"
                                            onmouseleave="window.modalHandlers['percorsi_corsi'].delLeave(this)"
                                            onclick="window.modalHandlers['percorsi_corsi'].delClick(<?php echo $corso['id'].','.$_REQUEST['id_cliente']; ?>)"
                                        ><span><?php echo icon('bin.svg'); ?></span></div>
                                    </div>
                                </div><?php
                            }?>
                        </div>
                    </div>
                </div><?php
                }?>
            </div>
        </div>
    </div>
</div>
<?php modal_script('percorsi_corsi'); ?>