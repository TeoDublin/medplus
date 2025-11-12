<?php 
    if(!isset($_REQUEST['id_percorso'])){
        throw new Exception("Error Processing Request", 1);
        exit;
    }
    $percorso = Select('*')->from('percorsi_terapeutici')->where("id={$_REQUEST['id_percorso']}")->first_or_false();
?>
<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Cambia Stato</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body save"
                data-id_percorso=<?php echo $_REQUEST['id_percorso'];?>
                data-id_cliente=<?php echo $_REQUEST['id_cliente'];?>
                >
                <div class="d-flex flex-row">
                    <div class="p-2 flex-fill">
                        <label class="form-label" for="stato">Voucher</label>
                        <?php 
                            echo "<select class=\"form-control text-center\" name=\"bnw\" value=\"{$percorso['bnw']}\">";
                                foreach(Enum('percorsi_terapeutici','bnw')->get() as $enum){
                                    $selected=$percorso['bnw']==$enum?'selected':'';
                                    echo "<option value=\"{$enum}\" {$selected}>{$enum}</option>";
                                }
                            echo "</select>";
                        ?>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['cambia_voucher'].btnSalva(this)">Salva</a>
            </div>
        </div>
    </div>
</div>
<?php modal_script('cambia_voucher'); ?>