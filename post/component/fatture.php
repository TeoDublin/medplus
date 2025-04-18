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
    }
    elseif($_REQUEST['btnClean']);
    else{
        $_POST['data']['da']=date('Y-m-01', strtotime('first day of last month'));
        $_POST['data']['a']=date('Y-m-t', strtotime('last month'));
        $where.=" AND `data` >='{$_POST['data']['da']}' AND `data` <='{$_POST['data']['a']}'";
    }

    $view_fatture = Select('*')->from('view_fatture')->where($where)->get_table();
    $somma_importo= number_format(Select("sum(importo) as importo")->from('view_fatture')->where($where)->col('importo'),2);
?>

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
        ?>
        <button class="btn btn-secondary ms-2" onclick="btnClean()">Pulisci Filtri</button><?php
    }
    ?>
</div>
<div>
    <span><?php echo "Quantità: {$view_fatture->total}, Somma: € {$somma_importo}"; ?></span>
</div>

<?php 
    if(!$view_fatture->result){?>
        <div class="card card-body mt-3 text-center"><h5>Non trovato</h5></div><?php
    }
    else{?>
        <div class="px-1">
            <table class="table table-striped table-hover text-center">
                <thead>
                    <tr>
                        <th class="w-10">Cliente</th>
                        <th class="w-5">N.</th>
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
                        <tr data-id=<?php echo $fattura['id']; ?>>
                            <td><?php echo $fattura['nominativo']; ?></td>
                            <td><?php echo $fattura['index']; ?></td>
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
<div class="floating-menu-btn">
    <button class="h-100 left"><?php echo icon('arrow-filled-left.svg'); ?></button>
    <button class="h-100 right"><?php echo icon('arrow-filled-right.svg'); ?></button>
</div>
<div class="floating-excel-btn" onclick="excel('post/excel_fatture.php')">
    <?php echo icon('excel.svg','green',50,50); ?>
</div>
<div class="floating-menu text-center">
    <div class="content p-0 h-100">
        <div class="pt-3 p-2">
            <h6>FILTRA</h6>
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
    </div>
    <div class="sticky-bottom w-100" onclick="btnFiltra()">
        <button class="btn btn-primary w-100">Filtra</button>
    </div>
</div>