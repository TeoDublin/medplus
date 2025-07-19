<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Esporta corso</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="p-2">
                    <div class="mb-3">
                        <label for="month" class="form-label">Seleziona il Mese</label>
                        <input
                            type="month"
                            class="form-control"
                            name="month"
                            id="month"
                        />
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['corsi_esporta'].btnSalva(this)">Esporta</a>
            </div>
        </div>
    </div>
</div>
<?php modal_script('corsi_esporta'); ?>