<div class="modal bg-dark bg-opacity-50" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Percorso Terapeutico</h4>
                <button type="button" class="btn-resize" aria-hidden="true" onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>                
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="container"></div>
            <div class="modal-body">
                <?php 
                    $result=$_REQUEST['id']?Select('p.*,pm.data_inizio,pm.scadenza')
                        ->from('percorsi','p')
                        ->left_join('percorsi_mensili pm on p.id = pm.id_percorso')
                        ->where("p.id={$_REQUEST['id']}")
                        ->first():[];
                    $hidden=$result['tipo_percorso']!='Mensile'?'hidden':'';
                ?>
                <div class="p-2">
                    <input type="text" id="id" name="id" value="<?php echo $result['id']??'';?>" hidden/>
                    <input type="text" id="id_cliente" name="id_cliente" value="<?php echo $_REQUEST['id_cliente']??'';?>" hidden/>
                    <div class="mb-3">
                        <label for="tipo_percorso" class="form-label">Tipo di Percorso</label>
                        <select class="form-control" id="tipo_percorso" name="tipo_percorso" value="<?php echo $result['tipo_percorso']??'';?>" 
                            onchange="window.modalHandlers['percorso_terapeutico'].changeTipoPercorso(this);"><?php                             
                            foreach(Enum('percorsi','tipo_percorso')->list as $enum){
                                if($result['tipo_percorso']&&$enum==$result['tipo_percorso'])echo "<option value=\"{$enum}\" selected>{$enum}</option>";
                                else echo "<option value=\"{$enum}\">{$enum}</option>";
                            }
                        ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="percorso" class="form-label">Percorso</label>
                        <input type="text" class="form-control" id="percorso" name="percorso" value="<?php echo $result['percorso']??'';?>"/>
                    </div>
                    <div class="mb-3 mensile" <?php echo $hidden; ?>>
                        <label for="data_inizio" class="form-label">Data Inizio</label>
                        <input type="date" class="form-control" id="data_inizio" name="data_inizio" value="<?php echo $result['data_inizio']??'';?>"/>
                    </div>
                    <div class="mb-3 mensile" <?php echo $hidden; ?>>
                        <label for="scadenza" class="form-label">Scadenza</label>
                        <input type="date" class="form-control" id="scadenza" name="scadenza" value="<?php echo $result['scadenza']??'';?>"/>
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Note</label>
                        <textarea type="text" class="form-control" id="note" name="note" value="<?php echo $result['note']??'';?>"><?php echo $result['note']??'';?></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['percorso_terapeutico'].btnSalva('<?php echo $_REQUEST['id_modal'];?>')">Salva</a>
            </div>
        </div>
    </div>
</div>
<?php modal_script('percorso_terapeutico'); ?>