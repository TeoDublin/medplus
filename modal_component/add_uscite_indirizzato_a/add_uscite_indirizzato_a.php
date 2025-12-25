<?php 
    if(isset($_REQUEST['id_indirizzato_a'])){
        if(!null_or_empty($_REQUEST['id_indirizzato_a'])){
            $indirizzato_a=Select('*')->from('uscite_indirizzato_a')->where("id={$_REQUEST['id_indirizzato_a']}")->first_or_false();
        }
    }
?>
<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Indirizzato a</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <?php echo div_load(); ?>
            <div class="modal-body save"
                data-id="<?php echo $_REQUEST['id_indirizzato_a']??''; ?>"
                >
                
                <div class="d-flex flex-row">
                    <div class="p-2 flex-fill">
                        <label class="form-label" for="indirizzato_a">Nome Società</label>
                        <input class="form-control" name="indirizzato_a" type="text" value="<?php echo $indirizzato_a['indirizzato_a']??''; ?>"/>
                    </div>
                   
                </div>

            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['indirizzato_a'].btnSalva(this)">Salva</a>
            </div>
        </div>
    </div>
</div>
<?php modal_script('add_uscite_indirizzato_a'); ?>