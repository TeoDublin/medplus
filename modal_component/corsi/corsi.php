<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Aggiungi corso</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body  overflow-auto flex-grow-1">
                <?php 
                    $result=$_REQUEST['id']?Select('*')->from('sedute')->where("id={$_REQUEST['id']}")->first():[];
                    $corsi = Select('*')
                        ->from('corsi')
                        ->orderby('categoria, corso ASC')
                        ->get();
                ?>
                <div class="p-2">
                    <div class="mb-3 ms-2">
                        <label for="id_corso" class="form-label">Corso</label>
                        <select class="form-select" id="id_corso" name="id_corso" value="<?php echo $result['id_corso']??''; ?>" 
                            onchange="window.modalHandlers['corsi'].changecorso(this);">
                            <?php 
                                $current_tipo = $current_categoria = '';
                                echo "<option value=\"\" class=\"ps-4  bg-white\" prezzo=\"\" tipo=\"\"></option>";
                                foreach ($corsi as $corso) {
                                    if ($current_categoria && $current_categoria != $corso['categoria']) {
                                        echo "</optgroup>";
                                        $current_categoria = '';
                                    }

                                    if ($current_tipo && $current_tipo != $corso['tipo']) {
                                        if ($current_categoria) {
                                            echo "</optgroup>";
                                        }
                                        echo "</optgroup>";
                                        $current_tipo = '';
                                    }

                                    if ($current_tipo != $corso['tipo']) {
                                        $current_tipo = $corso['tipo'];
                                        echo "<optgroup label=\"*{$corso['tipo']}\" class=\"fw-bold\">";
                                    }

                                    if ($current_categoria != $corso['categoria']) {
                                        $current_categoria = $corso['categoria'];
                                        echo "<optgroup label=\"-- {$corso['categoria']}\" class=\"ps-3 bg-primary-7\">";
                                    }

                                    $selected = (isset($result['id_corso']) && $result['id_corso'] == $corso['id']) ? 'selected' : '';
                                    echo "<option value=\"{$corso['id']}\" class=\"ps-4 bg-white\" prezzo=\"{$corso['prezzo']}\" tipo=\"{$corso['tipo']}\" $selected>{$corso['corso']}</option>";            
                                }

                                if ($current_categoria) echo "</optgroup>";
                                if ($current_tipo) echo "</optgroup>";
                            ?>
                        </select>
                    </div>
                    <div class="mb-3 ms-2" id="div_sedute" hidden>
                        <label for="sedute" class="form-label">Sessioni</label>
                        <input type="number" class="form-control" id="sedute" name="sedute" value="<?php echo $result['sedute']??'1'; ?>" 
                            onchange="window.modalHandlers['corsi'].changeSedute(this);"> 
                    </div>
                    <div class="mb-3 ms-2" id="div_prezzo_tabellare_a_seduta" hidden>
                        <label for="prezzo_tabellare_a_seduta" class="form-label" >Prezzo tabellare a seduta</label>
                        <input type="number" class="form-control" id="prezzo_tabellare_a_seduta" value="" read-only disabled/> 
                    </div>
                    <div class="mb-3 ms-2" id="div_prezzo_a_seduta"hidden>
                        <label for="prezzo_a_seduta" class="form-label" >Prezzo a seduta</label>
                        <input type="number" class="form-control" id="prezzo_a_seduta" value="<?php echo $result['prezzo']??''; ?>" 
                            onchange="window.modalHandlers['corsi'].changePrezzoASeduta(this);"> 
                    </div>
                    <div class="mb-3 ms-2" id="div_prezzo_tabellare" hidden>
                        <label for="prezzo_tabellare" class="form-label" >Prezzo tabellare</label>
                        <input type="number" class="form-control" id="prezzo_tabellare" name="prezzo_tabellare" value="" read-only disabled/> 
                    </div>
                    <div class="mb-3 ms-2" id="div_prezzo" hidden>
                        <label for="prezzo" class="form-label" >Prezzo</label>
                        <input type="number" class="form-control" id="prezzo" name="prezzo" value="" onchange="window.modalHandlers['corsi'].changePrezzo(this);"/> 
                    </div>
            </div>
        </div>
        <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['corsi'].save(this,'<?php echo $_REQUEST['table'];?>')">Salva</a>
            </div>
        </div>
    </div>
    <?php modal_script('corsi'); ?>
</div>