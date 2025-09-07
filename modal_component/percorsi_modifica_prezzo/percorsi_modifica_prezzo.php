<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Modifica Prezzo</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="p-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="prezzo" class="form-label">Prezzo</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="prezzo"
                                    id="prezzo"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['percorsi_modifica_prezzo'].btnSalva(this)">Salva</a>
            </div>
            <script id="request" type="application/json">
                <?php echo json_encode($_REQUEST, JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);?>
            </script>

        </div>
    </div>
</div>
<?php modal_script('percorsi_modifica_prezzo'); ?>