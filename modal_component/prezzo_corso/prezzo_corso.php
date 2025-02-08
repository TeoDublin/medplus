<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">prezzo_corso</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="p-2">
                    <div class="mb-2">
                        <label class="form-label" for="prezzo_tabellare">Prezzo Tabellare</label>
                        <input class="form-control" name="prezzo_tabellare" value="<?php echo $_REQUEST['prezzo_tabellare']; ?>" disabled/>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="prezzo">Prezzo</label>
                        <input class="form-control" name="prezzo" id="prezzo" value="<?php echo $_REQUEST['prezzo']; ?>"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['prezzo_corso'].btnSalva(this,<?php echo $_REQUEST['id'].','.$_REQUEST['id_cliente']; ?>)">Salva</a>
            </div>
        </div>
    </div>
</div>
<?php modal_script('prezzo_corso'); ?>