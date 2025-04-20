<?php 
    $data_set=data_set($_REQUEST);
?>
<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Conferma Corso</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="p-2">
                    <div class="mb-2">
                        <label class="form-label" for="nominativo">Nominativo</label>
                        <input class="form-control" name="nominativo" type="text" value="<?php echo $_REQUEST['nominativo']; ?>" readonly disabled/>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="data_inizio">Data Inizio</label>
                        <input class="form-control" name="data_inizio" type="date" value="<?php echo $_REQUEST['data_inizio']; ?>" readonly disabled/>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="scadenza">Scadenza</label>
                        <input 
                            class="form-control" 
                            name="scadenza" 
                            type="date" 
                            value="<?php echo $_REQUEST['scadenza']; ?>" 
                            readonly disabled
                        />
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="prezzo">Prezzo</label>
                        <input class="form-control" id="prezzo" name="prezzo" type="number" value="<?php echo $_REQUEST['prezzo']??$_REQUEST['prezzo_tabellare']; ?>"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-tertiary" <?php echo $data_set; ?> onclick="window.modalHandlers['conferma_corso'].btnRipristina(this)">Ripristina</a>
                <a href="#" class="btn btn-primary" <?php echo $data_set; ?> onclick="window.modalHandlers['conferma_corso'].btnSospensione(this)">Sospensione</a>
                <a href="#" class="btn btn-secondary" <?php echo $data_set; ?> onclick="window.modalHandlers['conferma_corso'].btnPresenza(this)">Presenza</a>
            </div>
        </div>
    </div>
</div>
<?php modal_script('conferma_corso'); ?>