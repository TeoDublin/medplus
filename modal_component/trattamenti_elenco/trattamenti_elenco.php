<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Aggiungi trattamento</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body  overflow-auto flex-grow-1">
                <style>
                    .trattamento-colore {
                        width: 28px;
                        height: 28px;
                        display: inline-grid;
                        place-items: center;
                        border: 1px solid #dadce0;
                        border-radius: 8px;
                        background: #fff;
                        padding: 0;
                    }
                    .trattamento-colore span {
                        width: 18px;
                        height: 18px;
                        display: block;
                        border: 1px solid rgba(0, 0, 0, 0.18);
                        border-radius: 50%;
                    }
                    .trattamento-colore.selected {
                        border-color: var(--base-bg-primary);
                        box-shadow: 0 0 0 2px var(--base-bg-primary);
                    }
                    .trattamento-colore:disabled {
                        opacity: 0.35;
                        cursor: not-allowed;
                    }
                    .trattamento-colori {
                        max-height: 104px;
                        overflow-y: auto;
                        padding: 3px;
                    }
                </style>
                <?php 
                    $result=$_REQUEST['id']?Select('*')->from('trattamenti')->where("id={$_REQUEST['id']}")->first():[];
                    $colori=Select('*')->from('trattamenti_colori')->orderby("
                        FIELD(nome,
                            'Grigio','Ardesia','Sabbia','Mattone',
                            'Rosso','Bordeaux','Corallo','Salmone','Pesca',
                            'Arancione','Ambra','Senape','Ocra',
                            'Giallo','Crema','Lime','Oliva','Pistacchio',
                            'Verde','Bosco','Smeraldo','Giada',
                            'Menta','Acquamarina','Petrolio','Turchese','Laguna','Ciano',
                            'Celeste','Azzurro','Carta da zucchero','Blu','Notte',
                            'Pervinca','Indaco','Lavanda','Lilla','Prugna','Viola','Malva',
                            'Fucsia','Cipria','Rosa'
                        ),
                        id ASC
                    ")->get();
                    $colori_usati=Select('id_colore')->from('trattamenti')->where('id_colore IS NOT NULL')->get();
                    $id_colore_corrente=$result['id_colore']??'';
                    $colori_non_disponibili=[];
                    foreach($colori_usati as $colore_usato){
                        if($colore_usato['id_colore'] != $id_colore_corrente){
                            $colori_non_disponibili[]=$colore_usato['id_colore'];
                        }
                    }
                ?>
                <div class="p-2">
                    <input name="id" value="<?php echo $_REQUEST['id']??'';?>" hidden/>
                    <div class="m-2">
                        <label for="id_categoria" class="form-label">Categoria</label><?php 
                        echo "<select class=\"form-control text-center\" name=\"id_categoria\" value=\"".($result['id_categoria']??'')."\">";
                            foreach(Select('*')->from('trattamenti_categorie')->get() as $enum){
                                $selected=($result['id_categoria']??'')==$enum['id']?'selected':'';
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
                    <div class="m-2">
                        <label for="id_colore" class="form-label">Colore calendario</label>
                        <input type="text" name="id_colore" value="<?php echo $id_colore_corrente; ?>" hidden/>
                        <div class="d-flex flex-row flex-wrap gap-2 trattamento-colori">
                            <button
                                type="button"
                                class="trattamento-colore <?php echo $id_colore_corrente ? '' : 'selected'; ?>"
                                title="Nessun colore"
                                data-id-colore=""
                                onclick="window.modalHandlers['trattamenti_elenco'].selectColor(this)"
                            >
                                <span style="background:#e8eaed"></span>
                            </button>
                            <?php foreach($colori as $colore) {
                                $selected = $id_colore_corrente == $colore['id'] ? 'selected' : '';
                                $disabled = in_array($colore['id'], $colori_non_disponibili) ? 'disabled' : '';
                                echo "<button type=\"button\" class=\"trattamento-colore {$selected}\" title=\"{$colore['nome']}\" data-id-colore=\"{$colore['id']}\" {$disabled} onclick=\"window.modalHandlers['trattamenti_elenco'].selectColor(this)\"><span style=\"background:{$colore['colore']}\"></span></button>";
                            } ?>
                        </div>
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
