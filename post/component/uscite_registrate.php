<?php 
    require_once '../../includes.php';
    function _has_filters(){
        return count($_POST)>0&&!isset($_REQUEST['btnClean']);
    }
    $where='1=1';
    $url='pagamenti.php';
    if(_has_filters()){
        if($_POST['data_pagamento']['all']);
        else{
            if($_POST['data_pagamento']['da'])$where.=" AND `data_pagamento` >='{$_POST['data_pagamento']['da']}'";
            if($_POST['data_pagamento']['a'])$where.=" AND `data_pagamento` <='{$_POST['data_pagamento']['a']}'";    
        }
        if($_POST['id_uscita'])$where.=" AND id_uscita ='{$_POST['id_uscita']}'";
    }
    elseif(isset($_REQUEST['btnClean']));
    else{
        $_POST['data_pagamento']['da']=date('Y-m-01');
        $_POST['data_pagamento']['a']=date('Y-m-d');
        $where.=" AND data_pagamento >='{$_POST['data_pagamento']['da']}' AND data_pagamento <='{$_POST['data_pagamento']['a']}'";
    }
    $view_uscite_registrate = Select('*')->from('view_uscite_registrate')->where($where)->orderby('data_pagamento ASC')->get_table();
    $somma_importo= number_format(Select("sum(importo) as importo")->from('view_uscite_registrate')->where($where)->col('importo'),2);
?>

<!-- where -->
<div class="filter-labels d-flex flex-row align-items-center bg-light p-2 w-100">
    <span class="fw-bold">FILTRI APPLICATI:</span>
    <?php
    if(_has_filters()){?>
        <?php
            if(isset($_POST['data_pagamento']['all']));
            else{
                if($_POST['data_pagamento']['da']) echo "<div class=\"filter-label bg-gray\"><span >Seduta Da: ".unformat_date($_POST['data_pagamento']['da'])."</span></div>"; 
                if($_POST['data_pagamento']['a']) echo "<div class=\"filter-label bg-gray\"><span >Seduta A: ".unformat_date($_POST['data_pagamento']['a'])."</span></div>";    
            } 
            if(isset($_POST['indirizzato_a'])) echo "<div class=\"filter-label bg-gray\"><span >Uscita: {$_POST['indirizzato_a']}</span></div>";
        ?>
        <button class="btn btn-secondary ms-2" onclick="btnClean()">Pulisci Filtri</button><?php
    }
    ?>
    <button class="btn btn-secondary ms-2 ms-auto" onclick="aggiungiUscita()">Aggiungi Uscita</button>
</div>
<div>
    <span><?php echo "Quantità: {$view_uscite_registrate->total}, Somma: € {$somma_importo}"; ?></span>
</div>

<!-- table -->
<?php 
    if(!$view_uscite_registrate->result){?>
        <div class="card card-body mt-3 text-center"><h5>Non trovato</h5></div><?php
    }
    else{?>
        <div class="px-1">
            <table class="table table-striped table-hover text-center">
                <thead>
                    <tr class="small">
                        <th>Categoria</th>
                        <th>Uscita</th>
                        <th>Indirizzato a</th>
                        <th>In Capo a</th>
                        <th>Data Pagamento</th>
                        <th>Tipo Pagamento</th>
                        <th>Importo</th>
                        <th>Voucher</th>
                        <th>Note</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody><?php 
                    foreach($view_uscite_registrate->result as $uscita){?>
                        <tr data-id=<?php echo $uscita['id']; ?> style="font-size:12px;line-height:8px; word-break:break-word;" >
                            <td onmouseenter="enterEdit(this)" onmouseleave="leaveEdit(this)" onclick="clickEdit(<?php echo $uscita['id']; ?>)"><?php echo $uscita['categoria']; ?></td>
                            <td onmouseenter="enterEdit(this)" onmouseleave="leaveEdit(this)" onclick="clickEdit(<?php echo $uscita['id']; ?>)"><?php echo $uscita['uscita']; ?></td>
                            <td onmouseenter="enterEdit(this)" onmouseleave="leaveEdit(this)" onclick="clickEdit(<?php echo $uscita['id']; ?>)"><?php echo $uscita['indirizzato_a']; ?></td>
                            <td onmouseenter="enterEdit(this)" onmouseleave="leaveEdit(this)" onclick="clickEdit(<?php echo $uscita['id']; ?>)"><?php echo $uscita['in_capo_a']; ?></td>
                            <td onmouseenter="enterEdit(this)" onmouseleave="leaveEdit(this)" onclick="clickEdit(<?php echo $uscita['id']; ?>)"><?php echo $uscita['data_pagamento']?unformat_date($uscita['data_pagamento']):'-'; ?></td>
                            <td onmouseenter="enterEdit(this)" onmouseleave="leaveEdit(this)" onclick="clickEdit(<?php echo $uscita['id']; ?>)"><?php echo $uscita['tipo_pagamento']; ?></td>
                            <td onmouseenter="enterEdit(this)" onmouseleave="leaveEdit(this)" onclick="clickEdit(<?php echo $uscita['id']; ?>)"><?php echo number_format($uscita['importo'],2); ?></td>
                            <td onmouseenter="enterEdit(this)" onmouseleave="leaveEdit(this)" onclick="clickEdit(<?php echo $uscita['id']; ?>)"><?php echo $uscita['voucher']; ?></td>
                            <td onmouseenter="enterEdit(this)" onmouseleave="leaveEdit(this)" onclick="clickEdit(<?php echo $uscita['id']; ?>)"><?php echo $uscita['note']; ?></td>
                            <td class="del"
                                onmouseenter="enterDel(this);"
                                onmouseleave="leaveDel(this);"
                                onclick="delClick(<?php echo $uscita['id']; ?>);"
                            ><?php echo icon('bin.svg','black',15,15); ?></td>
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
<?php Html()->pagination2($view_uscite_registrate,$url); ?>

<!-- floating menu -->
<div class="floating-menu-btn">
    <button class="h-100 left"><?php echo icon('arrow-filled-left.svg'); ?></button>
    <button class="h-100 right"><?php echo icon('arrow-filled-right.svg'); ?></button>
</div>
<div class="floating-excel-btn" onclick="excel('post/excel_uscite.php')">
    <div class="d-grid tip d-none justify-content-center align-content-center">
        <span>Scarrica excel con le uscite filtrate</span>
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
        <div class="accordion p-1" id="filter_data">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_data_pagamento" aria-expanded="false" aria-controls="collapse_filter_data_pagamento">
                    Data Pagamento
                    </button>
                </h2>
                <div id="collapse_filter_data_pagamento" class="accordion-collapse collapse" data-bs-parent="#filter_data_pagamento">
                    <div class="accordion-body">
                        <div>
                            <label for="data_pagamento_da">Da</label>
                            <input class="form-control" type="date" id="data_pagamento_da" value="<?php echo isset($_POST['data_pagamento']['da']) ? $_POST['data_pagamento']['da'] : ''; ?>">
                        </div>
                        <div>
                            <label for="data_pagamento_a">A</label>
                            <input class="form-control" type="date" id="data_pagamento_a" value="<?php echo isset($_POST['data_pagamento']['a']) ? $_POST['data_pagamento']['a'] : ''; ?>">
                        </div>
                        <div class="mt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="data_pagamento_all" 
                                    value="<?= isset($_POST['data_pagamento']['all']) ? htmlspecialchars($_POST['data_pagamento']['all']) : '' ?>" 
                                    <?= !empty($_POST['data_pagamento']['all']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="data_pagamento_all">
                                    Seleziona tutto
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion p-1" id="filter_indirizzato_a">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_indirizzato_a" aria-expanded="false" aria-controls="collapse_filter_indirizzato_a">
                    Uscita
                    </button>
                </h2>
                <div id="collapse_filter_indirizzato_a" class="accordion-collapse collapse" data-bs-parent="#filter_indirizzato_a">
                    <div class="accordion-body">
                        <div>
                            <label for="indirizzato_a">Uscita</label>
                            <select class="form-control" id="indirizzato_a" value="<?php echo $_POST['id_uscita'] ?? ''; ?>">
                                <option value="">Tutti</option>
                                <?php 
                                    foreach (Select('*')->from('uscite_uscita')->orderby('uscita ASC')->get() as $enum) {
                                        $id_uscita = isset($_POST['id_uscita']) ? $_POST['id_uscita'] : 0;
                                        $selected = $id_uscita == $enum['id']?'selected':'';
                                        echo "<option {$selected} value=\"{$enum['id']}\">{$enum['uscita']}</option>";
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