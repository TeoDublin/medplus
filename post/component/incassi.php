<?php 
    require_once '../../includes.php';
    $session=Session();
    $ruolo=$session->get('ruolo')??false;
    
    function _has_filters(){
        return count($_POST)>0&&!isset($_REQUEST['btnClean']);
    }

    if($ruolo=='display'){
        $where = "origine <> 'senza_fattura' AND bnw <> 'no'";
    }
    else{
        $where = '1=1';
    }
    

    function _pagamenti($where){
        return Select('p.*, c.nominativo')
            ->from('pagamenti','p')
            ->left_join('clienti c on p.id_cliente = c.id')
            ->where($where)
            ->orderby('data DESC')
            ->get_table();
    }

    $url='pagamenti.php';
    
    if(_has_filters()){

        if(!isset($_POST['data']['all'])){
            if(isset_n_valid($_POST['data']['da'])){
                $where.=" AND data >='{$_POST['data']['da']}'";
            }
            if(isset_n_valid($_POST['data']['a'])){
                $where.=" AND data <='{$_POST['data']['a']}'";
            }    
        }

        if(isset_n_valid($_POST['stato'])){
            $where.=" AND stato IN('".implode("','",$_POST['stato'])."')";
        }

        if(isset_n_valid($_POST['origine'])){
            $where.=" AND origine IN('".implode("','",$_POST['origine'])."')";
        }

        if(isset_n_valid($_POST['bnw'])){
            $where.=" AND bnw IN('".implode("','",$_POST['bnw'])."')";
        }

        if(isset_n_valid($_POST['metodo'])){
            $where.=" AND metodo IN('".implode("','",$_POST['metodo'])."')";
        }

        if(isset_n_valid($_POST['cliente'])){
            $where.=" AND id_cliente IN(".implode(',',$_POST['cliente']).")";
        }
    }
    elseif(!isset($_REQUEST['btnClean'])){
        $_POST['data']['da']=date('Y-m-01');
        $_POST['data']['a']=date('Y-m-d');
        $where.=" AND `data` >='{$_POST['data']['da']}' AND `data` <='{$_POST['data']['a']}'";
    }

    $pagamenti = _pagamenti($where);
    $sum= Select("sum(imponibile) as imponibile, sum(imponibile) + sum(bollo) as 'imponibile + bollo', sum(totale) as totale")->from('pagamenti')->where($where)->first();
?>

<!-- where -->
<div class="filter-labels d-flex flex-row align-items-center bg-light p-2">
    <span class="fw-bold">FILTRI APPLICATI:</span>
    <?php
    if(_has_filters()){?>
        <?php
            if(!isset_n_valid($_POST['data_seduta']['all'])){
                if(isset_n_valid($_POST['data']['da'])){
                    echo "<div class=\"filter-label bg-gray\"><span > Da: ".unformat_date($_POST['data']['da'])."</span></div>"; 
                }
                if(isset_n_valid($_POST['data']['a'])){
                    echo "<div class=\"filter-label bg-gray\"><span >A: ".unformat_date($_POST['data']['a'])."</span></div>";
                } 
            } 

            if(isset_n_valid($_POST['stato'])){
                echo "<div class=\"filter-label bg-gray\"><span >Stato Pagamento: ".implode(', ',$_POST['stato'])."</span></div>";
            }
            if(isset_n_valid($_POST['origine'])){
                echo "<div class=\"filter-label bg-gray\"><span >Tipo Pagamento: ".implode(', ',$_POST['origine'])."</span></div>";
            }
            if(isset_n_valid($_POST['bnw'])){
                echo "<div class=\"filter-label bg-gray\"><span >Voucher: ".implode(', ',$_POST['bnw'])."</span></div>";
            }
            if(isset_n_valid($_POST['metodo'])){
                echo "<div class=\"filter-label bg-gray\"><span >Metodo: ".implode(', ',$_POST['metodo'])."</span></div>";
            }
            if(isset_n_valid($_POST['nominativo'])){
                echo "<div class=\"filter-label bg-gray\"><span >Nominativo: ".implode(', ',$_POST['nominativo'])."</span></div>";
            }

        ?>
        <button class="btn btn-secondary ms-2" onclick="btnClean()">Pulisci Filtri</button><?php
    }
    ?>
</div>
<div>
    <span><?php echo "Totale: € ".number_format($sum['totale'],2, ',', '.').", Imponibile: € ".number_format($sum['imponibile'],2, ',', '.'); ?></span>
</div>

<!-- table -->
<?php 
    if(!$pagamenti->result){?>
        <div class="card card-body mt-3 text-center"><h5>Non trovato</h5></div><?php
    }
    else{?>
        <div class="px-1">
            <table class="table table-striped table-hover text-center">
                <thead>
                    <tr class="small">
                        <th class="w-15">nominativo</th>
                        <th class="w-15">origine</th>
                        <th class="w-10">metodo</th>
                        <th class="w-10">data</th>
                        <th class="w-5">imponibile</th>
                        <th class="w-5">inps</th>
                        <th class="w-5">bollo</th>
                        <th class="w-5">totale</th>
                        <th class="w-10">note</th>
                        <th class="w-10">stato</th>
                        <th class="w-10">voucher</th>
                    </tr>
                </thead>
                <tbody><?php 
                    foreach($pagamenti->result as $pagamento){?>
                        <tr data-id=<?php echo $pagamento['id']; ?> style="font-size:12px;line-height:8px; word-break:break-word;">
                            <td><?php echo $pagamento['nominativo']; ?></td>
                            <td><?php echo $pagamento['origine']; ?></td>
                            <td><?php echo $pagamento['metodo']; ?></td>
                            <td><?php echo $pagamento['data']?format($pagamento['data'],'d/m/y'):'-'; ?></td>
                            <td><?php echo number_format($pagamento['imponibile'],2, ',', '.'); ?></td>
                            <td><?php echo number_format($pagamento['inps'],2, ',', '.'); ?></td>
                            <td><?php echo number_format($pagamento['bollo'],2, ',', '.'); ?></td>
                            <td><?php echo number_format($pagamento['totale'],2, ',', '.'); ?></td>
                            <td><?php echo $pagamento['note']; ?></td>
                            <td><?php echo $pagamento['stato']; ?></td>
                            <td><?php echo $pagamento['bnw']??'-'; ?></td>
                        </tr><?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php
    }
?>
<?php Html()->pagination2($pagamenti,$url); ?>

<!-- floating menu -->
<div class="floating-menu-btn">
    <button class="h-100 left"><?php echo icon('arrow-filled-left.svg'); ?></button>
    <button class="h-100 right"><?php echo icon('arrow-filled-right.svg'); ?></button>
</div>

<div class="floating-excel-btn" onclick="excel('post/excel_incassi.php')">
    <div class="d-grid tip d-none justify-content-center align-content-center">
        <span>Scarrica excel con incassi filtrati</span>
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
                            <select class="form-control selectpicker" id="cliente" value="<?php echo $_POST['cliente']; ?>" multiple>
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
                            <select class="form-control selectpicker" id="stato" value="<?php echo $_POST['stato']; ?>" multiple>
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
        <div class="accordion p-1" id="filter_metodo">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_metodo" aria-expanded="false" aria-controls="collapse_filter_metodo">
                    Metodo Pagamento
                    </button>
                </h2>
                <div id="collapse_filter_metodo" class="accordion-collapse collapse" data-bs-parent="#filter_metodo">
                    <div class="accordion-body">
                        <div>
                            <label for="metodo">Metodo Pagamento</label>
                            <select class="form-control selectpicker" id="metodo" value="<?php echo $_POST['metodo']; ?>" multiple>
                                <?php 
                                    foreach (Enum('pagamenti','metodo')->get() as $enum) {
                                        $selected = in_array($enum,( $_POST['metodo'] ?? []))?'selected':'';
                                        echo "<option {$selected} value=\"{$enum}\">{$enum}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion p-1" id="filter_origine">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_origine" aria-expanded="false" aria-controls="collapse_filter_origine">
                    Tipo Pagamento
                    </button>
                </h2>
                <div id="collapse_filter_origine" class="accordion-collapse collapse" data-bs-parent="#filter_origine">
                    <div class="accordion-body">
                        <div>
                            <label for="origine">Tipo Pagamento</label>
                            <select class="form-control selectpicker" id="origine" value="<?php echo $_POST['origine']; ?>" multiple>
                                <?php 
                                    foreach (Enum('pagamenti','origine')->get() as $enum) {
                                        $selected = in_array($enum,( $_POST['origine'] ?? []))?'selected':'';
                                        echo "<option {$selected} value=\"{$enum}\">{$enum}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion p-1" id="filter_bnw">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_bnw" aria-expanded="false" aria-controls="collapse_filter_bnw">
                    Voucher
                    </button>
                </h2>
                <div id="collapse_filter_bnw" class="accordion-collapse collapse" data-bs-parent="#filter_bnw">
                    <div class="accordion-body">
                        <div>
                            <label for="bnw">Voucher</label>
                            <select class="form-control selectpicker" id="bnw" value="<?php echo $_POST['bnw']; ?>" multiple>
                                <?php 
                                    foreach (Enum('pagamenti','bnw')->get() as $enum) {
                                        $selected = in_array($enum,( $_POST['bnw'] ?? []))?'selected':'';
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