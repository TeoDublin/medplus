<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Aggiungi Sedute</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="p-2">
                    <label class="form-label" for="qtt">Quantità</label>
                    <input type="number" name="qtt" id="qtt" class="form-control" />
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['add_sedute'].btnSalva(this,<?php echo $_REQUEST['id_cliente'].','.$_REQUEST['id_percorso'].','.$_REQUEST['id_trattamento']; ?>)">Salva</a>
            </div>
        </div>
    </div>
</div>
<?php modal_script('add_sedute'); ?>