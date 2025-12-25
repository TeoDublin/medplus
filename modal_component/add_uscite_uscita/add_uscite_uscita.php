<?php 
    if(isset($_REQUEST['id_uscita'])){
        if(!null_or_empty($_REQUEST['id_uscita'])){
            $uscita=Select('*')->from('uscite_uscita')->where("id={$_REQUEST['id_uscita']}")->first_or_false();
        }
    }
?>
<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Uscita</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <?php echo div_load(); ?>
            <div class="modal-body save"
                data-id="<?php echo $_REQUEST['id_uscita']??''; ?>"
                >
                
                <div class="d-flex flex-row">
                    <div class="p-2 flex-fill">
                        <label class="form-label" for="uscita">uscita</label>
                        <input class="form-control" name="uscita" type="text" value="<?php echo $uscita['uscita']??''; ?>"/>
                    </div>
                   
                </div>

            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['uscita'].btnSalva(this)">Salva</a>
            </div>
        </div>
    </div>
</div>
<?php modal_script('add_uscite_uscita'); ?>