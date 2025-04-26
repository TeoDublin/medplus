<?php 
    require_once '../../includes.php';
    $session=Session();
    $ruolo=$session->get('ruolo')??false;
    function _has_filters(){
        return count($_POST)>0&&!isset($_REQUEST['btnClean']);
    }
    $where=$ruolo=='display'?"( tipo_pagamento IS NULL OR tipo_pagamento <> 'Senza Fattura' )":'1=1';
    $url='pagamenti.php';
    if(_has_filters()){
        if($_POST['data_seduta']['all']);
        else{
            if($_POST['data_seduta']['da'])$where.=" AND data_seduta >='{$_POST['data_seduta']['da']}'";
            if($_POST['data_seduta']['a'])$where.=" AND data_seduta <='{$_POST['data_seduta']['a']}'";    
        }
        if(isset($_POST['id_terapista']))$where.=" AND id_terapista ='{$_POST['id_terapista']}'";
        if($_POST['stato_seduta'])$where.=" AND stato_seduta ='{$_POST['stato_seduta']}'";
        if($_POST['stato_pagamento'])$where.=" AND stato_pagamento ='{$_POST['stato_pagamento']}'";
        if($_POST['stato_saldato_terapista'])$where.=" AND stato_saldato_terapista ='{$_POST['stato_saldato_terapista']}'";
        if($_POST['cliente'])$where.=" AND id_cliente ='{$_POST['cliente']}'";
    }
    elseif(isset($_REQUEST['btnClean']));
    else{
        $_POST['stato_seduta']='Conclusa';
        $_POST['data_seduta']['da']=date('Y-m-01');
        $_POST['data_seduta']['a']=date('Y-m-d');
        $where.=" AND data_seduta >='{$_POST['data_seduta']['da']}' AND data_seduta <='{$_POST['data_seduta']['a']}'";
        $where.=" AND stato_seduta ='{$_POST['stato_seduta']}'";
    }
    $view_sedute = Select('*')->from('view_sedute')->where($where)->orderby('data_seduta ASC')->get_table();
    $somma_prezzo= number_format(Select("sum(prezzo) as prezzo")->from('view_sedute')->where($where)->col('prezzo'),2);
?>

<!-- where -->
<div class="filter-labels d-flex flex-row align-items-center bg-light p-2">
    <span class="fw-bold">FILTRI APPLICATI:</span>
    <?php
    if(_has_filters()){?>
        <?php
            if(isset($_POST['data_seduta']['all']));
            else{
                if($_POST['data_seduta']['da']) echo "<div class=\"filter-label bg-gray\"><span >Seduta Da: ".unformat_date($_POST['data_seduta']['da'])."</span></div>"; 
                if($_POST['data_seduta']['a']) echo "<div class=\"filter-label bg-gray\"><span >Seduta A: ".unformat_date($_POST['data_seduta']['a'])."</span></div>";    
            } 
            if(isset($_POST['id_terapista'])) echo "<div class=\"filter-label bg-gray\"><span >Terapista: {$_POST['terapista']}</span></div>";
            if($_POST['stato_seduta']) echo "<div class=\"filter-label bg-gray\"><span >Stato Seduta: {$_POST['stato_seduta']}</span></div>";
            if($_POST['stato_pagamento']) echo "<div class=\"filter-label bg-gray\"><span >Stato Pagamento: {$_POST['stato_pagamento']}</span></div>";
            if($_POST['stato_saldato_terapista']) echo "<div class=\"filter-label bg-gray\"><span >Stato Saldato Terapista: {$_POST['stato_saldato_terapista']}</span></div>";
            if(isset($_POST['nominativo'])) echo "<div class=\"filter-label bg-gray\"><span >Nominativo: {$_POST['nominativo']}</span></div>";
        ?>
        <button class="btn btn-secondary ms-2" onclick="btnClean()">Pulisci Filtri</button><?php
    }
    ?>
</div>
<div>
    <span><?php echo "Quantità: {$view_sedute->total}, Somma: € {$somma_prezzo}"; ?></span>
</div>

<!-- table -->
<?php 
    if(!$view_sedute->result){?>
        <div class="card card-body mt-3 text-center"><h5>Non trovato</h5></div><?php
    }
    else{?>
        <div class="px-1">
            <table class="table table-striped table-hover text-center">
                <thead>
                    <tr class="small">
                        <th class="w-10">Cliente</th>
                        <th class="w-5">Acron.</th>
                        <th class="w-5">N.</th>
                        <th class="w-10">Stato Seduta</th>
                        <th class="w-10">Data Seduta</th>
                        <th class="w-5">Prezzo</th>
                        <th class="w-10">Stato Pagamento</th>
                        <th class="w-10">Terapista</th>
                        <th class="w-5">% Terap.</th>
                        <th class="w-5">Saldo Terap.</th>
                        <th class="w-5">Saldato Terap.</th>
                        <th class="w-10">Data Saldato Terap.</th>
                        <th class="w-10">Stato Saldato Terap.</th>
                    </tr>
                </thead>
                <tbody><?php 
                    foreach($view_sedute->result as $seduta){?>
                        <tr data-id=<?php echo $seduta['id']; ?> style="font-size:12px;line-height:8px; word-break:break-word;">
                            <td><?php echo $seduta['nominativo']; ?></td>
                            <td><?php echo $seduta['acronimo']; ?></td>
                            <td><?php echo $seduta['index']; ?></td>
                            <td><?php echo $seduta['stato_seduta']; ?></td>
                            <td><?php echo $seduta['data_seduta']?unformat_date($seduta['data_seduta']):'-'; ?></td>
                            <td><?php echo number_format($seduta['prezzo'],2); ?></td>
                            <td><?php echo $seduta['stato_pagamento']; ?></td>
                            <td><?php echo $seduta['terapista']; ?></td>
                            <td><?php echo number_format($seduta['percentuale_terapista'],0); ?></td>
                            <td><?php echo number_format($seduta['saldo_terapista'],2); ?></td>
                            <td><?php echo number_format($seduta['saldato_terapista'],2); ?></td>
                            <td><?php echo unformat_date($seduta['data_saldato_terapista']); ?></td>
                            <td><?php echo $seduta['stato_saldato_terapista']; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php
    }
?>
<?php Html()->pagination2($view_sedute,$url); ?>

<!-- floating menu -->
<div class="floating-menu-btn">
    <button class="h-100 left"><?php echo icon('arrow-filled-left.svg'); ?></button>
    <button class="h-100 right"><?php echo icon('arrow-filled-right.svg'); ?></button>
</div>
<div class="floating-input-sedute" onclick="inputExcel()">
    <div class="d-grid tip d-none justify-content-center align-content-center">
        <span>Aggiorna dati delle sedute importando un file excel</span>
    </div>
    <div class="div-icon">
        <?php echo icon('upload.svg','#0d394a',25,25); ?>
    </div>
</div>
<div class="floating-download-pdf-btn" onclick="pdf('sedute','<?php echo session_id(); ?>')">
    <div class="d-grid tip d-none justify-content-center align-content-center">
        <span>Scarrica pdf con le sedute filtrate</span>
    </div>
    <div class="div-icon">
        <?php echo icon('pdf.svg','#0d394a',25,25); ?>
    </div>
</div>
<div class="floating-excel-btn" onclick="excel('post/excel_sedute.php')">
    <div class="d-grid tip d-none justify-content-center align-content-center">
        <span>Scarrica excel con le sedute filtrate</span>
    </div>
    <div class="div-icon">
        <?php echo icon('excel.svg','#0d394a',25,25); ?>
    </div>
</div>

<!-- filters -->
<div class="floating-menu text-center">
    <div class="content p-0 h-100">
        <div class="pt-3 p-2">
            <h6>FILTRA</h6>
        </div>
        <div class="accordion p-1" id="filter_cliente">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_cliente" aria-expanded="false" aria-controls="collapse_filter_cliente">
                    Cliente
                    </button>
                </h2>
                <div id="collapse_filter_cliente" class="accordion-collapse collapse" data-bs-parent="#filter_cliente">
                    <div class="accordion-body">
                        <div>
                            <label for="cliente">Nominativo Cliente</label>
                            <select class="form-control" id="cliente" value="<?php echo $_POST['cliente']; ?>">
                                <option value="">Tutti</option>
                                <?php 
                                    foreach(Select('*')->from('clienti')->get() as $enum){
                                        $selected = $_POST['cliente']==$enum['id']?'selected':'';
                                        echo "<option value=\"{$enum['id']}\" {$selected}>{$enum['nominativo']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion p-1" id="filter_data">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_data" aria-expanded="false" aria-controls="collapse_filter_data">
                    Data Seduta
                    </button>
                </h2>
                <div id="collapse_filter_data" class="accordion-collapse collapse" data-bs-parent="#filter_data">
                    <div class="accordion-body">
                        <div>
                            <label for="data_seduta_da">Da</label>
                            <input class="form-control" type="date" id="data_seduta_da" value="<?php echo $_POST['data_seduta']['da']; ?>">
                        </div>
                        <div>
                            <label for="data_seduta_a">A</label>
                            <input class="form-control" type="date" id="data_seduta_a" value="<?php echo $_POST['data_seduta']['a']; ?>">
                        </div>
                        <div class="mt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="data_seduta_all" 
                                    value="<?= isset($_POST['data_seduta']['all']) ? htmlspecialchars($_POST['data_seduta']['all']) : '' ?>" 
                                    <?= !empty($_POST['data_seduta']['all']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="data_seduta_all">
                                    Seleziona tutto
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion p-1" id="filter_id_terapista">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_terapista" aria-expanded="false" aria-controls="collapse_filter_terapista">
                    Terapista
                    </button>
                </h2>
                <div id="collapse_filter_terapista" class="accordion-collapse collapse" data-bs-parent="#filter_id_terapista">
                    <div class="accordion-body">
                        <div>
                            <label for="id_terapista">Terapista</label>
                            <select class="form-control" id="id_terapista" value="<?php echo $_POST['id_terapista']; ?>">
                                <option value="">Tutti</option>
                                <option value="0" <?= (isset($_POST['id_terapista']) && $_POST['id_terapista'] === "0") ? 'selected' : '' ?>>Non Assegnato</option>
                                <?php 
                                    foreach (Select('*')->from('terapisti')->get() as $terapista) {
                                        $selected=$_POST['id_terapista']&&$_POST['id_terapista']==$terapista['id']?'selected':'';
                                        echo "<option {$selected} value=\"{$terapista['id']}\">{$terapista['terapista']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion p-1" id="filter_stato_seduta">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_stato_seduta" aria-expanded="false" aria-controls="collapse_filter_stato_seduta">
                    Stato Seduta
                    </button>
                </h2>
                <div id="collapse_filter_stato_seduta" class="accordion-collapse collapse" data-bs-parent="#filter_stato_seduta">
                    <div class="accordion-body">
                        <div>
                            <label for="stato_seduta">Stato Seduta</label>
                            <select class="form-control" id="stato_seduta" value="<?php echo $_POST['stato_seduta']; ?>">
                                <option value="">Tutti</option>
                                <?php 
                                    foreach (Enum('percorsi_terapeutici_sedute_prenotate','stato_prenotazione')->get() as $enum) {
                                        $selected=$_POST['stato_seduta']&&$_POST['stato_seduta']==$enum?'selected':'';
                                        echo "<option {$selected} value=\"{$enum}\">{$enum}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion p-1" id="filter_stato_pagamento">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_stato_pagamento" aria-expanded="false" aria-controls="collapse_filter_stato_pagamento">
                    Stato Pagamento
                    </button>
                </h2>
                <div id="collapse_filter_stato_pagamento" class="accordion-collapse collapse" data-bs-parent="#filter_stato_pagamento">
                    <div class="accordion-body">
                        <div>
                            <label for="stato_pagamento">Stato Pagamento</label>
                            <select class="form-control" id="stato_pagamento" value="<?php echo $_POST['stato_pagamento']; ?>">
                                <option value="">Tutti</option>
                                <?php 
                                    foreach (Enum('percorsi_terapeutici_sedute','stato_pagamento')->get() as $enum) {
                                        $selected=$_POST['stato_pagamento']&&$_POST['stato_pagamento']==$enum?'selected':'';
                                        echo "<option {$selected} value=\"{$enum}\">{$enum}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion p-1" id="filter_stato_saldato_terapista">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_stato_saldato_terapista" aria-expanded="false" aria-controls="collapse_filter_stato_saldato_terapista">
                    Stato Pagamento Terapista
                    </button>
                </h2>
                <div id="collapse_filter_stato_saldato_terapista" class="accordion-collapse collapse" data-bs-parent="#filter_stato_saldato_terapista">
                    <div class="accordion-body">
                        <div>
                            <label for="stato_saldato_terapista">Pagamento Terapista</label>
                            <select class="form-control" id="stato_saldato_terapista" value="<?php echo $_POST['stato_saldato_terapista']; ?>">
                                <option value="">Tutti</option>
                                <?php 
                                    foreach (Enum('percorsi_terapeutici_sedute','stato_saldato_terapista')->get() as $enum) {
                                        $selected=$_POST['stato_saldato_terapista']&&$_POST['stato_saldato_terapista']==$enum?'selected':'';
                                        echo "<option {$selected} value=\"{$enum}\">{$enum}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sticky-bottom w-100" onclick="btnFiltra()">
        <button class="btn btn-primary w-100">Filtra</button>
    </div>
</div>