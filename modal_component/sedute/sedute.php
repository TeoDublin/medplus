<div class="modal bg-dark bg-opacity-50" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Aggiungi Trattamento</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="container"></div>
            <div class="modal-body">
                <?php 
                    $result=$_REQUEST['id']?Select('*')->from('sedute')->where("id={$_REQUEST['id']}")->first():[];
                    $trattamenti = Select('t.*')
                        ->from('trattamenti', 't')
                        ->orderby('t.tipo, t.categoria, t.trattamento ASC')
                        ->get();                
                ?>
                <div class="p-2">
                    <input type="text" id="id_cliente" name="id_cliente" value="<?php echo $_REQUEST['id_cliente']??'';?>" hidden/>
                    <input type="text" id="id_percorso" name="id_percorso" value="<?php echo $_REQUEST['id_percorso']??'';?>" hidden/>
                    <div class="mb-3 ms-2">
                        <label for="id_trattamento" class="form-label">Trattamento</label>
                        <select class="form-select" id="id_trattamento" name="id_trattamento" value="<?php echo $result['id_trattamento']??''; ?>" onchange="changeTrattamento(this);">
                            <?php 
                                $current_tipo = $current_categoria = '';
                                echo "<option value=\"\" class=\"ps-4  bg-white\" prezzo=\"\" tipo=\"\"></option>";
                                foreach ($trattamenti as $trattamento) {
                                    if ($current_categoria && $current_categoria != $trattamento['categoria']) {
                                        echo "</optgroup>";
                                        $current_categoria = '';
                                    }

                                    if ($current_tipo && $current_tipo != $trattamento['tipo']) {
                                        if ($current_categoria) {
                                            echo "</optgroup>";
                                        }
                                        echo "</optgroup>";
                                        $current_tipo = '';
                                    }

                                    if ($current_tipo != $trattamento['tipo']) {
                                        $current_tipo = $trattamento['tipo'];
                                        echo "<optgroup label=\"*{$trattamento['tipo']}\" class=\"fw-bold\">";
                                    }

                                    if ($current_categoria != $trattamento['categoria']) {
                                        $current_categoria = $trattamento['categoria'];
                                        echo "<optgroup label=\"-- {$trattamento['categoria']}\" class=\"ps-3 bg-primary-7\">";
                                    }

                                    $selected = (isset($result['id_trattamento']) && $result['id_trattamento'] == $trattamento['id']) ? 'selected' : '';
                                    echo "<option value=\"{$trattamento['id']}\" class=\"ps-4 bg-white\" prezzo=\"{$trattamento['prezzo']}\" tipo=\"{$trattamento['tipo']}\" $selected>{$trattamento['trattamento']}</option>";            
                                }

                                if ($current_categoria) echo "</optgroup>";
                                if ($current_tipo) echo "</optgroup>";
                            ?>
                        </select>
                    </div>
                    <div class="mb-3 ms-2" id="div_sedute" hidden>
                        <label for="sedute" class="form-label">Sedute</label>
                        <input type="number" class="form-control" id="sedute" name="sedute" value="<?php echo $result['sedute']??'1'; ?>" onchange="changeSedute(this);"> 
                    </div>
                    <div class="mb-3 ms-2" id="div_prezzo_tabellare_a_seduta" hidden>
                        <label for="prezzo_tabellare_a_seduta" class="form-label" >Prezzo tabellare a seduta</label>
                        <input type="number" class="form-control" id="prezzo_tabellare_a_seduta" value="" read-only disabled/> 
                    </div>
                    <div class="mb-3 ms-2" id="div_prezzo_a_seduta"hidden>
                        <label for="prezzo_a_seduta" class="form-label" >Prezzo a seduta</label>
                        <input type="number" class="form-control" id="prezzo_a_seduta" value="<?php echo $result['prezzo']??''; ?>" onchange="changePrezzoASeduta(this);"> 
                    </div>
                    <div class="mb-3 ms-2" id="div_prezzo_tabellare" hidden>
                        <label for="prezzo_tabellare" class="form-label" >Prezzo tabellare</label>
                        <input type="number" class="form-control" id="prezzo_tabellare" value="" read-only disabled/> 
                    </div>
                    <div class="mb-3 ms-2" id="div_prezzo" hidden>
                        <label for="prezzo" class="form-label" >Prezzo</label>
                        <input type="number" class="form-control" id="prezzo" name="prezzo" value="" onchange="changePrezzo(this);"/> 
                    </div>
            </div>
            <div class="modal-footer">
                <a href="#" data-bs-dismiss="modal" class="btn btn-secondary">Anulla</a>
                <a href="#" class="btn btn-primary" onclick="btnSalva('<?php echo $_REQUEST['id_modal'];?>')">Salva</a>
            </div>
        </div>
    </div>
</div>
<?php script('modal_component/sedute/sedute.js'); ?>