<?php 
    if(isset($_REQUEST['id_categoria'])){
        if(!null_or_empty($_REQUEST['id_categoria'])){
            $categoria=Select('*')->from('uscite_categoria')->where("id={$_REQUEST['id_categoria']}")->first_or_false();
        }
    }
?>
<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Categoria</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <?php echo div_load(); ?>
            <div class="modal-body save"
                data-id="<?php echo $_REQUEST['id_categoria']??''; ?>"
                >
                
                <div class="d-flex flex-row">
                    <div class="p-2 flex-fill">
                        <label class="form-label" for="categoria">Categoria</label>
                        <input class="form-control" name="categoria" type="text" value="<?php echo $categoria['categoria']??''; ?>"/>
                    </div>
                   
                </div>

            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['categoria'].btnSalva(this)">Salva</a>
            </div>
        </div>
    </div>
</div>
<?php modal_script('add_uscite_categoria'); ?>