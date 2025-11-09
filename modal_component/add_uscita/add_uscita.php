<?php 
    if(isset_n_valid($_REQUEST['id'])){
        $uscita=Select('*')->from('uscite_per_giorno')->where("id={$_REQUEST['id']}")->first_or_false();
    }
?>
<div class="modal bg-dark bg-opacity-50" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Pendenze</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>                
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="container"></div>
            <div class="modal-body save"
                data-id="<?php echo $uscita['id']??''; ?>"
                >
                <div class="d-flex flex-row">
                    <div class="p-2 flex-fill">
                        <label class="form-label" for="categoria">Categoria</label>
                        <select class="form-control" name="categoria" value="<?php echo $uscita['categoria'] ?? ''; ?>">
                            <option>Seleziona</option>
                            <?php 
                                foreach (Enum('uscite','categoria')->get() as $enum) {
                                    $selected=$uscita['categoria']==$enum?'selected':'';
                                    echo "<option value=\"{$enum}\" {$selected}>{$enum}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="p-2 w-30">
                        <label class="form-label" for="in_capo_a">In Capo A</label>
                        <select class="form-control" name="in_capo_a" value="<?php echo $uscita['in_capo_a'] ?? ''; ?>">
                            <option>Seleziona</option>
                            <?php 
                                foreach (Enum('uscite','in_capo_a')->get() as $enum) {
                                    $selected=$uscita['in_capo_a']==$enum?'selected':'';
                                    echo "<option value=\"{$enum}\" {$selected}>{$enum}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="p-2 w-30">
                        <label class="form-label" for="id_uscita">Uscita</label>
                        <select class="form-control" name="id_uscita" value="<?php echo $uscita['id_uscita']??''; ?>">
                            <option>Seleziona</option>
                            <?php 
                                foreach (Select('*')->from('uscite')->orderby('nome ASC')->get() as $enum) {
                                    $selected=isset($uscita['id_uscita'])&&$enum['id']==$uscita['id_uscita']?'selected':'';
                                    echo "<option value=\"{$enum['id']}\" {$selected}>{$enum['nome']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="d-flex flex-row">
                    <div class="p-2 flex-fill">
                        <label class="form-label" for="data">Data Pagamento</label>
                        <input class="form-control" name="data" type="date" value="<?php echo $uscita['data']??''; ?>"/>
                    </div>
                    <div class="p-2 w-50">
                        <label class="form-label" for="tipo_pagamento">Tipo Pagamento</label>
                        <select class="form-control" name="tipo_pagamento" value="<?php echo $uscita['tipo_pagamento'] ?? ''; ?>">
                            <option>Seleziona</option>
                            <?php 
                                foreach (Enum('uscite_per_giorno','tipo_pagamento')->get() as $enum) {
                                    $selected=$uscita['tipo_pagamento']==$enum?'selected':'';
                                    echo "<option value=\"{$enum}\" {$selected}>{$enum}</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="d-flex flex-row">
                    <div class="p-2 flex-fill">
                        <label class="form-label" for="indirizzato_a">Indirizzato A</label>
                        <select class="form-control" name="indirizzato_a" id="indirizzato_a" value="<?php echo $uscita['indirizzato_a'] ?? ''; ?>">
                            <option>Seleziona</option>
                            <?php 
                                foreach (Select('*')->from('indirizzato_a')->get() as $enum) {
                                    $selected=$uscita['indirizzato_a']==$enum['id']?'selected':'';
                                    echo "<option value=\"{$enum['id']}\" {$selected}>{$enum['nome']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="p-2 w-10 mt-auto" onclick="window.modalHandlers['add_uscita'].indirizzato_a(this)">
                        <button class="btn btn-primary w-100">Aggiungi</button>
                    </div>
                    <div class="p-2 w-10 mt-auto" onclick="window.modalHandlers['add_uscita'].indirizzato_a(this)">
                        <button class="btn btn-secondary w-100">Modifica</button>
                    </div>
                </div>

                <div class="d-flex flex-row">
                    <div class="p-2 flex-fill">
                        <label class="form-label" for="importo">Importo</label>
                        <input class="form-control" name="importo" type="number" value="<?php echo $uscita['importo']??''; ?>"/>
                    </div>
                    <div class="p-2 w-50">
                        <label class="form-label" for="voucher">Voucher</label>
                        <select class="form-control" name="voucher" value="<?php echo $uscita['voucher'] ?? ''; ?>">
                            <option>Seleziona</option>
                            <?php 
                                foreach (Enum('uscite_per_giorno','voucher')->get() as $enum) {
                                    $selected=$uscita['voucher']==$enum?'selected':'';
                                    echo "<option value=\"{$enum}\" {$selected}>{$enum}</option>";
                                }
                            ?>
                        </select>
                    </div>
                   
                </div>

                <div class="d-flex flex-row">
                     <div class="p-2 flex-fill">
                        <label class="form-label" for="note">Note</label>
                        <textarea class="form-control" name="note" value="<?php echo $uscita['note']??''; ?>"></textarea>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['add_uscita'].btnSalva(this)">Salva</a>
            </div>
        </div>
    </div>
</div>
<?php modal_script('add_uscita'); ?>