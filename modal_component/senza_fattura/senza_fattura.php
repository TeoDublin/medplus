<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Aggiungi corso</h4>
                <button type="button" class="btn-resize" aria-hidden="true" onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body  overflow-auto flex-grow-1">
                <?php 
                    $result=$_REQUEST['id']?Select('*')->from('view_corsi')->where("id={$_REQUEST['id']}")->first():[];
                    $_data=str_replace('"',"'",json_encode($_REQUEST['_data']??[]));
                ?>
                <div class="p-2">
                    <input type="number" name="id_cliente" value="<?php echo $_REQUEST['id_cliente'];?>" hidden/> 
                    <div class="m-2">
                        <label for="valore" class="form-label" >Valore</label>
                        <input type="number" class="form-control" name="valore" value=""/> 
                    </div>
                </div>
        </div>
        <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['senza_fattura'].btnSalva(this,<?php echo $_data;?>)">Salva</a>
            </div>
        </div>
    </div>
    <?php modal_script('senza_fattura'); ?>
</div>