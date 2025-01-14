<div class="modal bg-dark bg-opacity-50" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg p-0">
        <div class="modal-content p-0">
            <div class="modal-header">
                <h4>Classe</h4>
                <button type="button" class="btn-resize" aria-hidden="true" onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <?php 
                    $result=$_REQUEST['id']?Select('*')->from('corsi_classi')->where("id={$_REQUEST['id']}")->first():[];
                    $corsi = Select('*')
                        ->from('corsi')
                        ->orderby('tipo, categoria, corso ASC')
                        ->get();
                ?>
                <div class="p-2">
                    <input name="id" value="<?php echo $result['id']??''; ?>" hidden/>
                    <div class="mb-3 ms-2">
                        <label for="classe" class="form-label" >Nome</label>
                        <input type="text" class="form-control" name="classe" value="<?php echo $result['classe']??''; ?>"/> 
                    </div>
                    <div class="mb-3 ms-2">
                        <label for="id_corso" class="form-label">Corso</label>
                        <select class="form-select" name="id_corso" value="<?php echo $result['id_corso']??''; ?>">
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
                    <div class="mb-3 ms-2">
                        <label for="note" class="form-label" >Note</label>
                        <textarea rows="4" class="form-control" name="note" value="<?php echo $result['note']??''; ?>"><?php echo $result['note']??''; ?></textarea> 
                    </div>
                </div>
            </div>
        <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['corsi_classi'].save(this)">Salva</a>
            </div>
        </div>
    </div>
    <?php modal_script('corsi_classi'); ?>
</div>