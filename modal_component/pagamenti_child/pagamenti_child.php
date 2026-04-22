<?php 
    style('modal_component/pagamenti_child/pagamenti_child.css');
    $shouldBollo = (double)$_REQUEST['sumSelected'] > 77.47;
?>

<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >

    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header"><h4 class="modal-title"><?= $_REQUEST['tipo_pagamento'];?></h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>

            <div class="modal-body  overflow-auto flex-grow-1">

                <div class="p-2">

                    <div class="m-2">
                        <label for="valore" class="form-label" >Valore</label>
                        <input type="number" class="form-control" name="valore" id="valore" value="<?php echo $_REQUEST['sumSelected']; ?>" disabled/> 
                    </div>

                    <?php if($_REQUEST['tipo_pagamento'] !== 'Contanti'):?>
                        <div class="m-2 d-flex flex-column">
                            <label for="inps" class="form-label" >Inps</label>
                            <input type="number" class="form-control" name="inps" id="inps" value="<?php echo 0; ?>" disabled/> 
                            <button class="toggle-btn ms-auto mt-1" onclick="window.modalHandlers['pagamenti_child'].switchInps(this)"></button>
                        </div>
                        <div class="m-2 d-flex flex-column">
                            <label for="bollo" class="form-label" >Bollo</label>
                            <input type="number" class="form-control" name="bollo" id="bollo" value="<?php echo $shouldBollo ? 2.0 : 0; ?>" disabled/> 
                            <button class="toggle-btn ms-auto mt-1 <?php echo $shouldBollo ? 'active' : ''; ?>" onclick="window.modalHandlers['pagamenti_child'].switchBollo(this)"></button>
                        </div>
                    <?php endif;?>

                    <div class="m-2">
                        <label for="data" class="form-label" >Data</label>
                        <input type="date" class="form-control" name="data" value="<?php echo now('Y-m-d'); ?>"/> 
                    </div>

                    <div class="m-2">
                        <label for="data" class="form-label" >Metodo</label><?php
                        echo "<select class=\"form-control text-center\" name=\"metodo\" value=\"Contanti\" ". ($_REQUEST['tipo_pagamento']=='Contanti' ? 'readonly disabled' : '') .">";
                            foreach(Enum('pagamenti_isico','metodo')->get() as $enum){
                                $selected=$enum=='Contanti'?'selected':'';
                                echo "<option value=\"{$enum}\" {$selected}>{$enum}</option>";
                            }
                        echo "</select>";?>
                    </div>

                    <?php if($_REQUEST['tipo_pagamento']=='Aruba'):?>
                        <div class="m-2">
                            <label for="data" class="form-label" >Fattura Aruba</label>
                            <input type="text" class="form-control" name="fattura_aruba" value=""/> 
                        </div>
                    <?php endif;?> 

                    <div class="m-2">
                        <label for="note" class="form-label" >Note</label>
                        <textarea class="form-control" name="note" value="" rows="4"></textarea> 
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['pagamenti_child'].btnSalva(this)">Salva</a>
            </div>

        </div>
    </div>
    <?php modal_script('pagamenti_child'); ?>
</div>