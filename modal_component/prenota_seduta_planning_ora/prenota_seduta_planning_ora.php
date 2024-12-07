<div class="modal bg-dark bg-opacity-50" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content px-3 text-center">
            <div class="modal-header">
                <h4>Prenota</h4>
                <button type="button" class="btn-resize" aria-hidden="true" onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <a href="#" data-bs-dismiss="modal" class="btn btn-secondary">Anulla</a>
                <a href="#" class="btn btn-primary" onclick="btnSalva()">Salva</a>
            </div>
        </div>
    </div>
</div>