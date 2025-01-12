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
                ?>
                <div class="p-2">
                    <input name="id" value="<?php echo $_REQUEST['id']??'';?>" hidden/>
                    <div class="m-2">
                        <label for="tipo" class="form-label">Tipo</label><?php 
                        echo "<select class=\"form-control text-center\" name=\"tipo\" value=\"{$result['tipo']}\">";
                            foreach(Enum('corsi','tipo')->list as $enum){
                                $selected=$result['tipo']==$enum?'selected':'';
                                echo "<option value=\"{$enum}\" {$selected}>{$enum}</option>";
                            }
                        echo "</select>";?>
                    </div>
                    <div class="m-2">
                        <label for="id_categoria" class="form-label">Categoria</label><?php 
                        echo "<select class=\"form-control text-center\" name=\"id_categoria\" value=\"{$result['id_categoria']}\">";
                            foreach(Select('*')->from('corsi_categorie')->get() as $enum){
                                $selected=$result['id_categoria']==$enum['id']?'selected':'';
                                echo "<option value=\"{$enum['id']}\" {$selected}>{$enum['categoria']}</option>";
                            }
                        echo "</select>";?>
                    </div>
                    <div class="m-2">
                        <label for="corso" class="form-label" >Corso</label>
                        <input type="text" class="form-control" name="corso" value="<?php echo $result['corso']??''; ?>"/> 
                    </div>
                    <div class="m-2">
                        <label for="prezzo" class="form-label" >Prezzo</label>
                        <input type="number" class="form-control" name="prezzo" value="<?php echo $result['prezzo']??''; ?>"/> 
                    </div>
                </div>
        </div>
        <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['corsi_elenco'].btnSalva(this,'<?php echo $_REQUEST['table'];?>')">Salva</a>
            </div>
        </div>
    </div>
    <?php modal_script('corsi_elenco'); ?>
</div>