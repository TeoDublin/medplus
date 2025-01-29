<?php 
    $corsi=Select('*')->from('view_classi')->where("id_cliente={$_REQUEST['id_cliente']}")->get_or_false();
?>
<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Corsi</h4>
                <button type="button" class="btn-resize" aria-hidden="true" onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body"><?php
                if(!$corsi){?>
                    <div class="card">
                        <div class="card-body">
                            <span>Non ci corsi per questo cliente.</span>
                        </div>
                    </div><?php
                }
                else{
                    foreach ($corsi as $corso) {?>
                        <div class="p-2 d-flex flex-row">
                            <div class="m-2">
                                <label for="corso" class="form-label" >Corso</label>
                                <input class="form-control" name="corso" value="<?php echo $corso['corso']; ?>" readonly/> 
                            </div>
                            <div class="m-2">
                                <label for="terapista" class="form-label" >Terapista</label>
                                <input class="form-control" name="terapista" value="<?php echo $corso['terapista']; ?>" readonly/> 
                            </div>
                            <div class="m-2">
                                <label for="data_inizio" class="form-label" >Inizio</label>
                                <input class="form-control" name="data_inizio" value="<?php echo $corso['data_inizio']; ?>" readonly/> 
                            </div>
                            <div class="m-2">
                                <label for="prezzo_tabellare" class="form-label" >Prezzo Tabellare</label>
                                <input class="form-control" name="prezzo_tabellare" value="<?php echo $corso['prezzo_tabellare']; ?>" readonly/> 
                            </div>
                            <div class="m-2">
                                <label for="prezzo" class="form-label" >Prezzo</label>
                                <input class="form-control" name="prezzo" value="<?php echo $corso['prezzo']; ?>" readonly/> 
                            </div>
                        </div>
                        <?php
                    }
                }?>
            </div>
        </div>
    </div>
</div>
<?php modal_script('percorsi_corsi'); ?>