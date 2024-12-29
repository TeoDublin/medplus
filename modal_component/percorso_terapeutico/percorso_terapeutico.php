<div class="modal bg-dark bg-opacity-50" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Percorso Terapeutico</h4>
                <button type="button" class="btn-resize" aria-hidden="true" onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>                
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="container"></div>
            <div class="modal-body">
                <?php $result=$_REQUEST['id']?Select('*')->from('percorsi')->where("id={$_REQUEST['id']}")->first():[];?>
                <div class="p-2">
                    <input type="text" id="id" name="id" value="<?php echo $result['id']??'';?>" hidden/>
                    <input type="text" id="id_cliente" name="id_cliente" value="<?php echo $_REQUEST['id_cliente']??'';?>" hidden/>
                    <div class="mb-3">
                        <label for="percorso" class="form-label">Percorso</label>
                        <input type="text" class="form-control" id="percorso" name="percorso" value="<?php echo $result['percorso']??'';?>"/>
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Note</label>
                        <textarea type="text" class="form-control" id="note" name="note" value="<?php echo $result['note']??'';?>"><?php echo $result['note']??'';?></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['percorso_terapeutico'].btnSalva('<?php echo $_REQUEST['id_modal'];?>')">Salva</a>
            </div>
        </div>
    </div>
</div>
<?php modal_script('percorso_terapeutico'); ?>