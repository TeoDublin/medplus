<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Aggiungi Uscita</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="p-2">
                    <label class="form-label" for="id_uscita">Uscita</label>
                    <select class="form-control" name="id_uscita" >
                        <option>Seleziona</option>
                        <?php 
                            foreach (Select('*')->from('uscite')->orderby('nome ASC')->get() as $enum) {
                                echo "<option value=\"{$enum['id']}\">{$enum['nome']}</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="p-2">
                    <label class="form-label" for="data">Data</label>
                    <input class="form-control" name="data" type="date"/>
                </div>
                <div class="p-2">
                    <label class="form-label" for="importo">Importo</label>
                    <input class="form-control" name="importo" type="number"/>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['add_uscita'].btnSalva(this)">Salva</a>
            </div>
        </div>
    </div>
</div>
<?php modal_script('add_uscita'); ?>