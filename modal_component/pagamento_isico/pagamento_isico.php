<?php 
    style('modal_component/pagamento_isico/pagamento_isico.css');
?>
<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Contanti</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body  overflow-auto flex-grow-1">
                <?php 
                    $_data=str_replace('"',"'",json_encode($_REQUEST['_data']??[]));
                    $shouldBollo = (double)$_REQUEST['sumSelected'] > 77.47;
                ?>
                <div class="p-2">
                    <input type="number" name="id_cliente" value="<?php echo $_REQUEST['id_cliente'];?>" hidden/> 
                    <div class="m-2">
                        <label for="valore" class="form-label" >Valore</label>
                        <input type="number" class="form-control" name="valore" id="valore" value="<?php echo $_REQUEST['sumSelected']; ?>" disabled/> 
                    </div>
                    <div class="m-2 d-flex flex-column">
                        <label for="inps" class="form-label" >Inps</label>
                        <input type="number" class="form-control" name="inps" id="inps" value="<?php echo 0; ?>" disabled/> 
                        <button class="toggle-btn ms-auto mt-1" onclick="window.modalHandlers['pagamento_isico'].switchInps(this)"></button>
                    </div>
                    <div class="m-2 d-flex flex-column">
                        <label for="bollo" class="form-label" >Bollo</label>
                        <input type="number" class="form-control" name="bollo" id="bollo" value="<?php echo $shouldBollo ? 2.0 : 0; ?>" disabled/> 
                        <button class="toggle-btn ms-auto mt-1 <?php echo $shouldBollo? 'active' : '';?>" onclick="window.modalHandlers['pagamento_isico'].switchBollo(this)"></button>
                    </div>
                    <div class="m-2">
                        <label for="data" class="form-label" >Data</label>
                        <input type="date" class="form-control" name="data" value="<?php echo now('Y-m-d'); ?>"/> 
                    </div>
                    <div class="m-2">
                        <label for="data" class="form-label" >Metodo</label><?php
                            echo "<select class=\"form-control text-center\" name=\"metodo\" value=\"Contanti\">";
                                foreach(Enum('pagamenti_isico','metodo')->get() as $enum){
                                    $selected=$enum=='Contanti'?'selected':'';
                                    echo "<option value=\"{$enum}\" {$selected}>{$enum}</option>";
                                }
                            echo "</select>";?>
                    </div>
                    <div class="m-2">
                        <label for="note" class="form-label" >Note</label>
                        <textarea class="form-control" name="note" value="" rows="4"></textarea> 
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['pagamento_isico'].btnSalva(this,<?php echo $_data;?>)">Salva</a>
            </div>
        </div>
    </div>
    <?php modal_script('pagamento_isico'); ?>
</div>