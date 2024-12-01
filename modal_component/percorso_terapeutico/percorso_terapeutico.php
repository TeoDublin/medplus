<div class="modal bg-dark bg-opacity-50" id="<?php echo $_REQUEST['id'];?>" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Percorso Terapeutico</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="container"></div>
            <div class="modal-body">
                <?php $result=[];?>
                <div class="p-2">
                    <input type="text" id="id" name="id" value="<?php echo $result['id']??'';?>" hidden/>
                    <div class="mb-3">
                        <label for="percorso" class="form-label">Percorso</label>
                        <input type="text" class="form-control" id="percorso" name="percorso" value="<?php echo $result['percorso']??'';?>"/>
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Note</label>
                        <textarea type="text" class="form-control" id="note" name="note" value="<?php echo $result['note']??'';?>"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" data-bs-dismiss="modal" class="btn btn-secondary">Anulla</a>
                <a href="#" class="btn btn-primary" onclick="btnSalva()">Salva</a>
            </div>
        </div>
    </div>
</div>
<?php script('modal_component/percorso_terapeutico/percorso_terapeutico.js'); ?>