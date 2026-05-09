<?php 
    require_once '../../../../includes.php';
    $session=Session();
    $ruolo=$session->get('ruolo')??false;

    $where='1=1';
    $url='pagamenti.php';

    if(has_filters()){

        if(!isset($_POST['data_creazione']['all'])){
            if(isset($_POST['data_creazione']['da'])){
                $where.=" AND data_creazione >='{$_POST['data_creazione']['da']}'";
            }
            if(isset($_POST['data_creazione']['a'])){
                $where.=" AND data_creazione <='{$_POST['data_creazione']['a']}'";
            }    
        }

        if(isset($_POST['index'])){
            $where.=" AND `index` ='{$_POST['index']}'";
        }

        if(isset($_POST['stato'])){
            $where.=" AND `stato` ='{$_POST['stato']}'";
        }

        if(isset($_POST['cliente'])){
            $where.=" AND id_cliente ='{$_POST['cliente']}'";
        }

    }
    elseif(!(int)cookie('btnClean')){
        $_POST['data_creazione']['da']=date('Y-m-d');
        $_POST['data_creazione']['a']=date('Y-m-d');
        $where.=" AND `data_creazione` >='{$_POST['data_creazione']['da']}' AND `data_creazione` <='{$_POST['data_creazione']['a']}'";
    }

    $view_fatture = Select('*')->from('view_fatture')->where($where)->get_table();
    $somma_importo = number_format( Select("sum(importo) as importo")->from('view_fatture')->where($where)->col('importo'), 2 );
?>

<!-- where -->
<div class="filter-labels d-flex flex-row align-items-center bg-light p-2">
    <span class="fw-bold">FILTRI APPLICATI:</span>
    <?php
    if(has_filters()){?>
        <?php

            if(!isset($_POST['data_creazione']['all'])){
                if(isset($_POST['data_creazione']['da'])){
                    echo "<div class=\"filter-label bg-gray\"><span >Da: ".unformat_date($_POST['data_creazione']['da'])."</span></div>";
                } 
                if(isset($_POST['data_creazione']['a'])){
                    echo "<div class=\"filter-label bg-gray\"><span >A: ".unformat_date($_POST['data_creazione']['a'])."</span></div>";
                }    
            } 

            if(isset($_POST['index'])){
                echo "<div class=\"filter-label bg-gray\"><span >Numero fattura: {$_POST['index']}</span></div>";
            }

            if(isset($_POST['stato'])){
                echo "<div class=\"filter-label bg-gray\"><span >stato: {$_POST['stato']}</span></div>";
            }

            if(isset($_POST['nominativo'])){
                echo "<div class=\"filter-label bg-gray\"><span >Nominativo: {$_POST['nominativo']}</span></div>";
            }
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
                        <th class="w-5">N.</th>
                        <th class="w-20">Cliente</th>
                        <th class="w-10">Stato Fattura</th>
                        <th class="w-10">Data Fattura</th>
                        <th class="w-10">Importo</th>
                        <th class="w-10">Metodo di pagamento</th>
                    </tr>
                </thead>
                <tbody><?php 
                    foreach($view_fatture->result as $fattura){?>
                        <tr data-id=<?php echo $fattura['id']; ?> style="font-size:12px;line-height:9px; word-break:break-word;">
                            <td><?php echo $fattura['index']; ?></td>
                            <td><?php echo $fattura['nominativo']; ?></td>
                            <td><?php echo $fattura['stato']; ?></td>
                            <td><?php echo $fattura['data_creazione']?unformat_date($fattura['data_creazione']):'-'; ?></td>
                            <td><?php echo number_format($fattura['importo'],2); ?></td>
                            <td><?php echo $fattura['metodo']; ?></td>
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
<div class="floating-menu text-center pb-5">
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
                            <select class="form-control selectpicker" id="cliente" value="<?php echo $_POST['cliente'] ?? '0'; ?>" multiple>
                                <?php 
                                    foreach(Select('*')->from('clienti')->get() as $enum){
                                        $selected = in_array($enum['id'],( $_POST['cliente'] ?? []))?'selected':'';
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
                            <label for="data_creazione_da">Da</label>
                            <input class="form-control" type="date" id="data_creazione_da" value="<?php echo $_POST['data_creazione']['da']; ?>">
                        </div>
                        <div>
                            <label for="data_creazione_a">A</label>
                            <input class="form-control" type="date" id="data_creazione_a" value="<?php echo $_POST['data_creazione']['a']; ?>">
                        </div>
                        <div class="mt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="data_creazione_all" 
                                    value="<?= isset($_POST['data_creazione']['all']) ? htmlspecialchars($_POST['data_creazione']['all']) : '' ?>" 
                                    <?= !empty($_POST['data_creazione']['all']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="data_creazione_all">
                                    Seleziona tutto
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion p-1" id="filter_index">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_index" aria-expanded="false" aria-controls="collapse_filter_index">
                    Numero Fattura
                    </button>
                </h2>
                <div id="collapse_filter_index" class="accordion-collapse collapse" data-bs-parent="#filter_index">
                    <div class="accordion-body">
                        <div>
                            <label for="index">Numero Fattura</label>
                            <select class="form-control" id="index" value="<?php echo $_POST['index']; ?>">
                                <option value="">Tutti</option>
                                <?php 
                                    foreach(Select('`index`')->from('fatture')->groupby('`index`')->get() as $enum){
                                        $selected = $_POST['index']==$enum['index']?'selected':'';
                                        echo "<option value=\"{$enum['index']}\" {$selected}>{$enum['index']}</option>";
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
                    Stato Pagamento
                    </button>
                </h2>
                <div id="collapse_filter_stato" class="accordion-collapse collapse" data-bs-parent="#filter_stato">
                    <div class="accordion-body">
                        <div>
                            <label for="stato">Stato Pagamento</label>
                            <select class="form-control selectpicker" id="stato" value="<?php echo json_encode($_POST['stato'] ?? []); ?>" multiple>
                                <?php 
                                    foreach (Enum('pagamenti','stato')->get() as $enum) {
                                        $selected = in_array($enum,( $_POST['stato'] ?? []))?'selected':'';
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