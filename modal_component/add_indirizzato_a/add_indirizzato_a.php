<?php 
    if(isset($_REQUEST['id'])){
        $indirizzato_a=Select('*')->from('indirizzato_a')->where("id={$_REQUEST['id']}")->first_or_false();
    }
?>
<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Aggiungi Trattamento</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body save"
                data-id="<?php echo $indirizzato_a['id']??''; ?>"
                >
                
                <div class="d-flex flex-row">
                    <div class="p-2 flex-fill">
                        <label class="form-label" for="nome">Nome Società</label>
                        <input class="form-control" name="nome" type="text" value="<?php echo $indirizzato_a['nome']??''; ?>"/>
                    </div>
                   
                </div>

            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['indirizzato_a'].btnSalva(this)">Salva</a>
            </div>
        </div>
    </div>
</div>
<?php modal_script('add_indirizzato_a'); ?>