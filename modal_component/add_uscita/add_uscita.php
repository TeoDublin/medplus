<?php 
    if($_REQUEST['id'])$uscita=Select('*')->from('uscite_per_giorno')->where("id={$_REQUEST['id']}")->first_or_false();
?>
<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Aggiungi Uscita</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" name="id" value="<?php echo $uscita['id']??''; ?>" hidden/>
                <div class="p-2">
                    <label class="form-label" for="id_uscita">Uscita</label>
                    <select class="form-control" name="id_uscita" value="<?php echo $uscita['id_uscita']??''; ?>">
                        <option>Seleziona</option>
                        <?php 
                            foreach (Select('*')->from('uscite')->orderby('nome ASC')->get() as $enum) {
                                $selected=isset($uscita['id_uscita'])&&$enum['id']==$uscita['id_uscita']?'selected':'';
                                echo "<option value=\"{$enum['id']}\" {$selected}>{$enum['nome']}</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="p-2">
                    <label class="form-label" for="data">Data</label>
                    <input class="form-control" name="data" type="date" value="<?php echo $uscita['data']??''; ?>"/>
                </div>
                <div class="p-2">
                    <label class="form-label" for="importo">Importo</label>
                    <input class="form-control" name="importo" type="number" value="<?php echo $uscita['importo']??''; ?>"/>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['add_uscita'].btnSalva(this)">Salva</a>
            </div>
        </div>
    </div>
</div>
<?php modal_script('add_uscita'); ?>