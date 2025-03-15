<?php 
    function _view_percorsi(){
        return $_REQUEST['id_percorso']?Select('*')->from('view_percorsi')->where("id={$_REQUEST['id_percorso']}")->first_or_false():false;
    }
    function _view_trattamenti(){
        return Select('t.*')
        ->from('view_trattamenti', 't')
        ->orderby('t.categoria, t.trattamento ASC')
        ->get();
    }
    function _percorsi_combo_trattamenti($id_combo){
        return Select('*')->from('percorsi_combo_trattamenti')->where("id_combo={$id_combo}")->get();
    }
    $view_trattamenti = _view_trattamenti();
    $view_percorsi=_view_percorsi();
?>
<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Aggiungi Trattamento</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-row">
                    <input type="text" id="single_tabellare" value="<?php echo $view_percorsi['prezzo_tabellare']??'0';?>" hidden/>
                    <div class="p-2 flex-fill">
                        <label for="acronimo" class="form-label">Acronimo</label>
                        <input type="text" class="form-control" name="acronimo" placeholder="Aggiungi trattamento" value="<?php echo $view_percorsi['acronimo']??'';?>" disabled/>
                    </div>
                    <div class="py-2 pe-2 w-15">
                        <label class="form-label" for="prezzo_tabellare">Tabellare</label>
                        <input type="number" class="form-control text-center" name="prezzo_tabellare" value="<?php echo $view_percorsi['prezzo_tabellare']??'0';?>" disabled/>
                    </div>
                    <div class="py-2 pe-2 w-15">
                        <label class="form-label" for="prezzo">Prezzo</label>
                        <input type="number" class="form-control text-center" name="prezzo" value="<?php echo $view_percorsi['prezzo']??'0';?>" onchange="window.modalHandlers['percorso_combo'].changePrezzo(this)"/>
                    </div>
                    <div class="py-2 pe-2 w-15">
                        <label for="sedute" class="form-label">Sedute</label>
                        <input type="number" class="form-control" name="sedute" value="<?php echo $view_percorsi['sedute']??'1';?>" disabled
                            onchange="window.modalHandlers['percorso_combo'].changeSedute(this)"
                            />
                    </div>
                </div>
                <div class="p-2">
                    <label for="note" class="form-label">Note</label>
                    <textarea name="note" class="form-control" row="3" placeholder="Note per il Trattamento"><?php echo $view_percorsi['note']??'';?></textarea>
                </div>
                <div class="p-2">
                    <div class="card">
                        <div class="card-header text-center"><h5 class="pt-2">Trattamenti</h5></div>
                        <div class="card-body">
                            <div class="trattamenti-titles <?php echo $_REQUEST['id_percorso']?'':'d-none';?>">
                                <div class="d-flex flex-row">
                                    <div class="p-1 flex-fill text-center">
                                        <label class="form-label">Trattamento</label>
                                    </div>
                                    <div class="p-1 w-15 text-center">
                                        <label class="form-label">Acr.</label>
                                    </div>
                                    <div class="p-1 w-20 text-center">
                                        <label class="form-label">Tabellare</label>
                                    </div>
                                    <div class="p-1 w-10 text-center">
                                        <label class="form-label">#</label>
                                    </div>
                                </div>
                            </div>
                            <div class="trattamenti-empty justify-content-center align-content-center d-flex mt-2 <?php echo $_REQUEST['id_percorso']?'d-none':'';?>">
                                <span class="text-center w-100">Aggiungi trattamenti</span>
                            </div>
                            <div class="" id="table-body">
                                <?php  
                                    if($view_percorsi){
                                        foreach(_percorsi_combo_trattamenti($view_percorsi['id_combo']) as $pct){
                                            echo "<div class=\"d-flex flex-row\">";
                                            $_REQUEST['id_trattamento']=$pct['id_trattamento'];
                                            require __DIR__.'/../../post/add_trattamento.php';
                                            echo "</div>";
                                        }
                                    }
                                ?>
                            </div>
                        </div>                                
                        <hr class="my-3">
                        <div class="d-flex flex-row">
                            <div class="p-2 flex-fill text-center">
                                <label for="add_trattamento" class="form-label">Trattamento</label>
                                <select class="form-select" id="add_trattamento" name="add_trattamento" value="">
                                    <option value="" selected>Seleziona Trattamento</option>
                                    <?php 
                                        foreach ($view_trattamenti as $trattamento) {
                                            if ($current_categoria && $current_categoria != $trattamento['categoria']) {
                                                echo "</optgroup>";
                                                $current_categoria = '';
                                            }
                                            if ($current_categoria != $trattamento['categoria']) {
                                                $current_categoria = $trattamento['categoria'];
                                                echo "<optgroup label=\"-- {$trattamento['categoria']}\" class=\"ps-3 bg-primary-7\">";
                                            }
                                            echo "<option value=\"{$trattamento['id']}\" class=\"ps-4 bg-white\" prezzo=\"{$trattamento['prezzo']}\">{$trattamento['trattamento']}</option>";            
                                        }
                                        if ($current_categoria) echo "</optgroup>";
                                    ?>
                                </select>                                    
                            </div>
                            <div class="p-2 w-40 text-center" onclick="window.modalHandlers['percorso_combo'].addTrattamento(this)">
                                <label for="btn" class="form-label">#</label>
                                <button name="btn" class="btn btn-primary w-100">Aggiungi Trattamento</button>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary w-100" onclick="window.modalHandlers['percorso_combo'].btnSalva(this,<?php echo $_REQUEST['id_cliente'].','.($_REQUEST['id_percorso']??'0').','.($view_percorsi['id_combo']??'0'); ?>)">Salva</a>
            </div>
        </div>
    </div>
</div>
<div id="done-loading"></div>
<?php modal_script('percorso_combo'); ?>