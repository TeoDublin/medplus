<?php 
    style('modal_component/percorso_combo/percorso_combo.css');

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
    $bnw = $view_percorsi['bnw']??'black';

    $arr_bnw = [
        'neutro'=>"background-color:transparent; border:1px solid #ccc;",
        'black'=>"background-color:black;",
        'white'=>"background-color:white;"
    ];
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
                    <div class="py-2 pe-2 w-10">
                        <input id="bnw" name="bnw" value="<?php echo $bnw;?>" hidden/>
                        <label for="btn" class="form-label">Colore</label>
                        <div class="dropdown w-100">
                            <button class="btn border dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
                                <span class="color-box" id="bnw-span" style="<?php echo $arr_bnw[$bnw];?>"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li class="dropdown-li" data-value="neutro" onclick="window.modalHandlers['percorso_combo'].dropdowLiClick(this)">
                                    <a class="dropdown-item" href="#"><span class="color-box" style="<?php echo $arr_bnw['neutro'];?>"></span></a>
                                </li>
                                <li class="dropdown-li" data-value="black" onclick="window.modalHandlers['percorso_combo'].dropdowLiClick(this)">
                                    <a class="dropdown-item" href="#"><span class="color-box" style="<?php echo $arr_bnw['black'];?>"></span></a>
                                </li>
                                <li class="dropdown-li" data-value="white" onclick="window.modalHandlers['percorso_combo'].dropdowLiClick(this)">
                                    <a class="dropdown-item" href="#"><span class="color-box" style="<?php echo $arr_bnw['white'];?>"></span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="py-2 pe-2 w-20">
                        <label for="btn" class="form-label">#</label>
                        <select class="form-select" id="realizzato_da" name="realizzato_da" value="<?php echo $view_percorsi['realizzato_da']??'1';?>">
                            <?php 
                                foreach(Enum('percorsi_terapeutici','realizzato_da')->list as $value){
                                    $selected = (isset($view_percorsi['realizzato_da']) && $view_percorsi['realizzato_da'] == $value) ? 'selected' : '';
                                    echo "<option value=\"{$value}\" class=\"ps-4  bg-white\" {$selected}>{$value}</option>";
                                }?>
                        </select>
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
                            <div class="p-2 w-20 text-center">
                                <label for="btn" class="form-label">#</label>
                                <button name="btn" class="btn btn-primary w-100" id="btnAddTrattamento" onclick="window.modalHandlers['percorso_combo'].addTrattamento(this)">Aggiungi Trattamento</button>
                            </div>
                        </div>
                        <div class="text-center p-1 bg-warning" id="isicoWarning" hidden>
                            <span>I trattamenti Isico non possono essere aggiunti insieme ai altri</span>
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