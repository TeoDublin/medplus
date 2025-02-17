<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Pagamento senza fattura</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body  overflow-auto flex-grow-1">
                <?php 
                    $_data=str_replace('"',"'",json_encode($_REQUEST['_data']??[]));
                ?>
                <div class="p-2">
                    <input type="number" name="id_cliente" value="<?php echo $_REQUEST['id_cliente'];?>" hidden/> 
                    <div class="m-2">
                        <label for="valore" class="form-label" >Valore</label>
                        <input type="number" class="form-control" name="valore" value=""/> 
                    </div>
                    <div class="m-2">
                        <label for="note" class="form-label" >Note</label>
                        <textarea class="form-control" name="note" value="" rows="4"></textarea> 
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['fatturato_aruba'].btnSalva(this,<?php echo $_data;?>)">Salva</a>
            </div>
        </div>
    </div>
    <?php modal_script('fatturato_aruba'); ?>
</div>