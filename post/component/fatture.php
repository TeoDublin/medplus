<?php 
    require_once '../../includes.php';
    $session=Session();
    $ruolo=$session->get('ruolo')??false;
    function _has_filters(){
        return count($_POST)>0&&!$_REQUEST['btnClean'];
    }
    $where='1=1';
    $url='pagamenti.php';
    if(_has_filters()){
        if($_POST['data']['all']);
        else{
            if($_POST['data']['da'])$where.=" AND `data` >='{$_POST['data']['da']}'";
            if($_POST['data']['a'])$where.=" AND `data` <='{$_POST['data']['a']}'";
            
        }
        if($_POST['fatturato_da'])$where.=" AND `fatturato_da` ='{$_POST['fatturato_da']}'";
        if($_POST['stato'])$where.=" AND `stato` ='{$_POST['stato']}'";
        if($_POST['confermato_dal_commercialista'])$where.=" AND `confermato_dal_commercialista` ='{$_POST['confermato_dal_commercialista']}'";
        if($_POST['cliente'])$where.=" AND id_cliente ='{$_POST['cliente']}'";
    }
    elseif($_REQUEST['btnClean']);
    else{
        $_POST['data']['da'] = date('Y-m-01');
        $_POST['data']['a'] = date('Y-m-d');
        $where.=" AND `data` >='{$_POST['data']['da']}' AND `data` <='{$_POST['data']['a']}'";
    }
    $view_fatture = Select('*')->from('view_fatture')->where($where)->get_table();
    $somma_importo= number_format(Select("sum(importo) as importo")->from('view_fatture')->where($where)->col('importo'),2);
?>

<!-- where -->
<div class="filter-labels d-flex flex-row align-items-center bg-light p-2">
    <span class="fw-bold">FILTRI APPLICATI:</span>
    <?php
    if(_has_filters()){?>
        <?php
            if($_POST['data']['all']);
            else{
                if($_POST['data']['da']) echo "<div class=\"filter-label bg-gray\"><span >Da: ".unformat_date($_POST['data']['da'])."</span></div>"; 
                if($_POST['data']['a']) echo "<div class=\"filter-label bg-gray\"><span >A: ".unformat_date($_POST['data']['a'])."</span></div>";    
            } 
            if($_POST['fatturato_da']) echo "<div class=\"filter-label bg-gray\"><span >fatturato da: {$_POST['fatturato_da']}</span></div>";
            if($_POST['stato']) echo "<div class=\"filter-label bg-gray\"><span >stato: {$_POST['stato']}</span></div>";
            if(isset($_POST['confermato_dal_commercialista'])) echo "<div class=\"filter-label bg-gray\"><span>Confermato Commercialista: ".((int)$_POST['confermato_dal_commercialista']?'Si':'No')."</span></div>";
            if($_POST['nominativo']) echo "<div class=\"filter-label bg-gray\"><span >Nominativo: {$_POST['nominativo']}</span></div>";
        ?>
        <button class="btn btn-secondary ms-2" onclick="btnClean()">Pulisci Filtri</button><?php
    }
    ?>
</div>
<div>
    <span><?php echo "Quantità: {$view_fatture->total}, Somma: € {$somma_importo}"; ?></span>
</div>

<!-- table -->
<?php 
    if(!$view_fatture->result){?>
        <div class="card card-body mt-3 text-center"><h5>Non trovato</h5></div><?php
    }
    else{?>
        <div class="px-1">
            <table class="table table-striped table-hover text-center">
                <thead>
                    <tr class="small">
                        <th class="w-10">Cliente</th>
                        <th class="w-10">Stato Fattura</th>
                        <th class="w-10">Data Fattura</th>
                        <th class="w-5">Importo</th>
                        <th class="w-10">Metodo di pagamento</th>
                        <th class="w-10">Fatturato da</th>
                        <th class="w-5">Confermato</th>
                    </tr>
                </thead>
                <tbody><?php 
                    foreach($view_fatture->result as $fattura){?>
                        <tr data-id=<?php echo $fattura['id']; ?> style="font-size:12px;line-height:9px; word-break:break-word;">
                            <td><?php echo $fattura['nominativo']; ?></td>
                            <td><?php echo $fattura['stato']; ?></td>
                            <td><?php echo $fattura['data']?unformat_date($fattura['data']):'-'; ?></td>
                            <td><?php echo number_format($fattura['importo'],2); ?></td>
                            <td><?php echo $fattura['metodo']; ?></td>
                            <td><?php echo $fattura['fatturato_da']; ?></td>
                            <td><?php echo $fattura['confermato_dal_commercialista']?'Si':'No'; ?></td>
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
<?php Html()->pagination2($view_fatture,$url); ?>

<!-- floating menu -->
<div class="floating-menu-btn">
    <button class="h-100 left"><?php echo icon('arrow-filled-left.svg'); ?></button>
    <button class="h-100 right"><?php echo icon('arrow-filled-right.svg'); ?></button>
</div>
<div class="floating-input-fatture" onclick="inputExcel()">
    <div class="d-grid tip d-none justify-content-center align-content-center">
        <span>Aggiorna dati della fattura importando un file excel</span>
    </div>
    <div class="div-icon">
        <?php echo icon('upload.svg','#0d394a',25,25); ?>
    </div>
</div>
<div class="floating-download-fatture-btn" onclick="zip('post/download_fatture.php')">
    <div class="d-grid tip d-none justify-content-center align-content-center">
        <span>Scarrica zip con le fatture filtrate</span>
    </div>
    <div class="div-icon">
        <?php echo icon('zip.svg','#0d394a',25,25); ?>
    </div>
</div>
<div class="floating-excel-btn" onclick="excel('post/excel_fatture.php')">
    <div class="d-grid tip d-none justify-content-center align-content-center">
        <span>Scarrica excel con le fatture filtrate</span>
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
        <div class="accordion p-1" id="filter_data">
            <div class="accordion-item">

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
                            Data
                            </button>
                        </h2>
                        <div id="collapse_filter_data" class="accordion-collapse collapse" data-bs-parent="#filter_data">
                            <div class="accordion-body">
                                <div>
                                    <label for="data_da">Da</label>
                                    <input class="form-control" type="date" id="data_da" value="<?php echo $_POST['data']['da']; ?>">
                                </div>
                                <div>
                                    <label for="data_a">A</label>
                                    <input class="form-control" type="date" id="data_a" value="<?php echo $_POST['data']['a']; ?>">
                                </div>
                                <div class="mt-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="data_all" 
                                            value="<?= isset($_POST['data']['all']) ? htmlspecialchars($_POST['data']['all']) : '' ?>" 
                                            <?= !empty($_POST['data']['all']) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="data_all">
                                            Seleziona tutto
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion p-1" id="filter_fatturato_da">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_fatturato_da" aria-expanded="false" aria-controls="collapse_filter_fatturato_da">
                            Fatturato da
                            </button>
                        </h2>
                        <div id="collapse_filter_fatturato_da" class="accordion-collapse collapse" data-bs-parent="#filter_fatturato_da">
                            <div class="accordion-body">
                                <div>
                                    <label for="fatturato_da">Fatturato da</label>
                                    <select class="form-control" id="fatturato_da" value="<?php echo $_POST['fatturato_da']; ?>">
                                        <option value="">Tutti</option>
                                        <?php 
                                            foreach(Enum('fatture','fatturato_da')->get() as $enum){
                                                $selected = $_POST['fatturato_da']==$enum?'selected':'';
                                                echo "<option value=\"{$enum}\" {$selected}>{$enum}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion p-1" id="filter_stato">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_stato" aria-expanded="false" aria-controls="collapse_filter_stato">
                            Stato
                            </button>
                        </h2>
                        <div id="collapse_filter_stato" class="accordion-collapse collapse" data-bs-parent="#filter_stato">
                            <div class="accordion-body">
                                <div>
                                    <label for="stato">Stato</label>
                                    <select class="form-control" id="stato" value="<?php echo $_POST['stato']; ?>">
                                        <option value="">Tutti</option>
                                        <?php 
                                            foreach(Enum('fatture','stato')->get() as $enum){
                                                $selected = $_POST['stato']==$enum?'selected':'';
                                                echo "<option value=\"{$enum}\" {$selected}>{$enum}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="accordion p-1" id="filter_confermato_dal_commercialista">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_confermato_dal_commercialista" aria-expanded="false" aria-controls="collapse_filter_confermato_dal_commercialista">
                            Confermato dal commercialista
                            </button>
                        </h2>
                        <div id="collapse_filter_confermato_dal_commercialista" class="accordion-collapse collapse" data-bs-parent="#filter_confermato_dal_commercialista">
                            <div class="accordion-body">
                                <div>
                                    <label for="confermato_dal_commercialista">Confermato</label>
                                    <select class="form-control" id="confermato_dal_commercialista" value="<?php echo $_POST['confermato_dal_commercialista']; ?>">
                                        <option value="">Tutti</option>
                                        <?php 
                                            foreach([0=>'No',1=>'Si'] as $k => $v){
                                                $selected = isset($_POST['confermato_dal_commercialista'])&&$_POST['confermato_dal_commercialista']==$k?'selected':'';
                                                echo "<option value=\"{$k}\" {$selected}>{$v}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
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