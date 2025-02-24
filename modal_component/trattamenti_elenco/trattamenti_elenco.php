<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Aggiungi trattamento</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body  overflow-auto flex-grow-1">
                <?php 
                    $result=$_REQUEST['id']?Select('*')->from('view_trattamenti')->where("id={$_REQUEST['id']}")->first():[];
                ?>
                <div class="p-2">
                    <input name="id" value="<?php echo $_REQUEST['id']??'';?>" hidden/>
                    <div class="m-2">
                        <label for="id_categoria" class="form-label">Categoria</label><?php 
                        echo "<select class=\"form-control text-center\" name=\"id_categoria\" value=\"{$result['id_categoria']}\">";
                            foreach(Select('*')->from('trattamenti_categorie')->get() as $enum){
                                $selected=$result['id_categoria']==$enum['id']?'selected':'';
                                echo "<option value=\"{$enum['id']}\" {$selected}>{$enum['categoria']}</option>";
                            }
                        echo "</select>";?>
                    </div>
                    <div class="m-2">
                        <label for="trattamento" class="form-label" >Trattamento</label>
                        <input type="text" class="form-control" name="trattamento" value="<?php echo $result['trattamento']??''; ?>"/> 
                    </div>
                    <div class="m-2">
                        <label for="acronimo" class="form-label" >Acronimo</label>
                        <input type="text" class="form-control" name="acronimo" value="<?php echo $result['acronimo']??''; ?>"/> 
                    </div>
                    <div class="m-2">
                        <label for="prezzo" class="form-label" >Prezzo</label>
                        <input type="number" class="form-control" name="prezzo" value="<?php echo $result['prezzo']??''; ?>"/> 
                    </div>
                </div>
        </div>
        <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['trattamenti_elenco'].btnSalva(this,'<?php echo $_REQUEST['table'];?>')">Salva</a>
            </div>
        </div>
    </div>
    <?php modal_script('trattamenti_elenco'); ?>
</div>