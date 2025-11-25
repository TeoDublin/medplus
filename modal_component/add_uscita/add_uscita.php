<?php 
    $uscita = [];

    if(isset($_REQUEST['id'])){
        if(!null_or_empty($_REQUEST['id'])){
            $uscita=Select('*')->from('view_uscite_registrate')->where("id={$_REQUEST['id']}")->first_or_false();
        }
    }

    if(isset($_REQUEST['id_indirizzato_a'])){
        $uscita['id_indirizzato_a'] = $_REQUEST['id_indirizzato_a'];
    }

    if(isset($_REQUEST['id_categoria'])){
        $uscita['id_categoria'] = $_REQUEST['id_categoria'];
    }

    if(isset($_REQUEST['id_uscita'])){
        $uscita['id_uscita'] = $_REQUEST['id_uscita'];
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
                        <label class="form-label" for="id_categoria">Categoria</label>
                        <select class="form-control" name="id_categoria" value="<?php echo $uscita['id_categoria'] ?? ''; ?>">
                            <option>Seleziona</option>
                            <?php 
                                foreach (Select('*')->from('uscite_categoria')->orderby('categoria ASC')->get() as $enum) {
                                    $selected = ($uscita['id_categoria'] ?? '') == $enum['id'] ? 'selected' : '';
                                    echo "<option value=\"{$enum['id']}\" {$selected}>{$enum['categoria']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="py-2 w-5 mt-auto" onclick="window.modalHandlers['add_uscita'].categoria(this,1)">
                        <button class="btn btn-primary w-100">
                            <?php echo icon('cloud-add.svg','white'); ?>
                        </button>
                    </div>
                    <div class="py-2 ms-1 w-5 mt-auto" onclick="window.modalHandlers['add_uscita'].categoria(this,0)">
                        <button class="btn btn-secondary w-100">
                            <?php echo icon('edit.svg','white'); ?>
                        </button>
                    </div>
                    <div class="p-2 w-30">
                        <label class="form-label" for="id_uscita">Uscita</label>
                        <select class="form-control" name="id_uscita" value="<?php echo $uscita['id_uscita'] ?? ''; ?>">
                            <option>Seleziona</option>
                            <?php 
                                foreach (Select('*')->from('uscite_uscita')->orderby('uscita ASC')->get() as $enum) {
                                    $selected= ( $uscita['id_uscita'] ?? '') == $enum['id'] ? 'selected' : '';
                                    echo "<option value=\"{$enum['id']}\" {$selected}>{$enum['uscita']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="py-2 w-5 mt-auto" onclick="window.modalHandlers['add_uscita'].uscita(this,1)">
                        <button class="btn btn-primary w-100">
                            <?php echo icon('cloud-add.svg','white'); ?>
                        </button>
                    </div>
                    <div class="py-2 ms-1 w-5 mt-auto" onclick="window.modalHandlers['add_uscita'].uscita(this,0)">
                        <button class="btn btn-secondary w-100">
                            <?php echo icon('edit.svg','white'); ?>
                        </button>
                    </div>
                    <div class="p-2 w-30">
                        <label class="form-label" for="in_capo_a">In Capo A</label>
                        <select class="form-control" name="in_capo_a" value="<?php echo $uscita['in_capo_a'] ?? ''; ?>">
                            <option>Seleziona</option>
                            <?php 
                                foreach (Enum('uscite','in_capo_a')->get() as $enum) {
                                    $selected= ($uscita['in_capo_a'] ?? '' ) == $enum ? 'selected' : '';
                                    echo "<option value=\"{$enum}\" {$selected}>{$enum}</option>";
                                }
                            ?>
                        </select>
                    </div>

                </div>
                
                <div class="d-flex flex-row">

                    <div class="p-2 flex-fill">
                        <label class="form-label" for="data_pagamento">Data Pagamento</label>
                        <input class="form-control" name="data_pagamento" type="date" value="<?php echo $uscita['data_pagamento']??''; ?>"/>
                    </div>

                    <div class="p-2 w-50">
                        <label class="form-label" for="tipo_pagamento">Tipo Pagamento</label>
                        <select class="form-control" name="tipo_pagamento" value="<?php echo $uscita['tipo_pagamento'] ?? ''; ?>">
                            <option>Seleziona</option>
                            <?php 
                                foreach (Enum('uscite_registrate','tipo_pagamento')->get() as $enum) {
                                    $selected = ( $uscita['tipo_pagamento']??'') == $enum ? 'selected' : '';
                                    echo "<option value=\"{$enum}\" {$selected}>{$enum}</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="d-flex flex-row">
                    <div class="p-2 flex-fill">
                        <label class="form-label" for="id_indirizzato_a">Indirizzato A</label>
                        <select class="form-control" name="id_indirizzato_a" id="id_indirizzato_a" value="<?php echo $uscita['id_indirizzato_a'] ?? ''; ?>">
                            <option>Seleziona</option>
                            <?php 
                                foreach (Select('*')->from('uscite_indirizzato_a')->get() as $enum) {
                                    $selected=($uscita['id_indirizzato_a']??'')==$enum['id']?'selected':'';
                                    echo "<option value=\"{$enum['id']}\" {$selected}>{$enum['indirizzato_a']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="py-2 w-5 mt-auto" onclick="window.modalHandlers['add_uscita'].indirizzato_a(this,1)">
                        <button class="btn btn-primary w-100">
                            <?php echo icon('cloud-add.svg','white'); ?>
                        </button>
                    </div>
                    <div class="py-2 ms-1 w-5 mt-auto" onclick="window.modalHandlers['add_uscita'].indirizzato_a(this,0)">
                        <button class="btn btn-secondary w-100">
                            <?php echo icon('edit.svg','white'); ?>
                        </button>
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
                                foreach (Enum('uscite_registrate','voucher')->get() as $enum) {
                                    $selected=$uscita['voucher']??''==$enum?'selected':'';
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