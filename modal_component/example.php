<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Example</h4>
                <button type="button" class="btn-resize" aria-hidden="true" onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="p-2">
                    <!-- CODE HERE -->
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['example'].btnSalva(this)">Salva</a>
            </div>
        </div>
    </div>
</div>
<?php modal_script('example'); ?>