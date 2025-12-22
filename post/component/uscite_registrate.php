<?php 
    require_once '../../includes.php';

    function _has_filters(){
        return count($_POST)>0&&!isset($_REQUEST['btnClean']);
    }

    $where='1=1';
    $url='pagamenti.php';
    
    if(_has_filters()){
        if(!isset($_POST['data_pagamento']['all'])){
            if(isset($_POST['data_pagamento']['da'])){
                $where.=" AND `data_pagamento` >='{$_POST['data_pagamento']['da']}'";
            }
            if(isset($_POST['data_pagamento']['a'])){
                $where.=" AND `data_pagamento` <='{$_POST['data_pagamento']['a']}'";
            }
        }
    
        if(isset($_POST['id_categoria'])){
            $where.=" AND id_categoria IN('".implode("','",$_POST['id_categoria'])."')";
        }

        if(isset($_POST['id_uscita'])){
            $where.=" AND id_uscita IN('".implode("','",$_POST['id_uscita'])."')";
        }

        if(isset($_POST['id_indirizzato_a'])){
            $where.=" AND id_indirizzato_a IN('".implode("','",$_POST['id_indirizzato_a'])."')";
        }

        if(isset($_POST['in_capo_a'])){
            $where.=" AND in_capo_a IN('".implode("','",$_POST['in_capo_a'])."')";
        }

        if(isset($_POST['tipo_pagamento'])){
            $where.=" AND tipo_pagamento IN('".implode("','",$_POST['tipo_pagamento'])."')";
        }

        if(isset($_POST['voucher'])){
            $where.=" AND voucher IN('".implode("','",$_POST['voucher'])."')";
        }

        if(isset($_POST['note'])){
            $where.=" AND note LIKE '%".$_POST['note']."%'";
        }
    }
    elseif(!isset($_REQUEST['btnClean'])){
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
		<div class="accordion p-1" id="filter_id_categoria">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_id_categoria" aria-expanded="false" aria-controls="collapse_filter_id_categoria">
                    Categoria
                    </button>
                </h2>
                <div id="collapse_filter_id_categoria" class="accordion-collapse collapse" data-bs-parent="#filter_id_categoria">
                    <div class="accordion-body">
                        <div>
                            <label for="id_categoria">Categoria</label>
                            <select class="form-control selectpicker" id="id_categoria" value="<?php echo $_POST['id_categoria'] ?? ''; ?>" multiple>
                                <?php 
                                    foreach (Select('*')->from('uscite_categoria')->get() as $enum) {
                                        $selected = in_array($enum['id'],( $_POST['id_categoria'] ?? []))?'selected':'';
                                        echo "<option {$selected} value=\"{$enum['id']}\">{$enum['categoria']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<div class="accordion p-1" id="filter_id_uscita">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_id_uscita" aria-expanded="false" aria-controls="collapse_filter_id_uscita">
                    Uscita
                    </button>
                </h2>
                <div id="collapse_filter_id_uscita" class="accordion-collapse collapse" data-bs-parent="#filter_id_uscita">
                    <div class="accordion-body">
                        <div>
                            <label for="id_uscita">Uscita</label>
                            <select class="form-control selectpicker" id="id_uscita" value="<?php echo $_POST['id_uscita'] ?? ''; ?>" multiple>
                                <?php 
                                    foreach (Select('*')->from('uscite_uscita')->get() as $enum) {
                                        $selected = in_array($enum['id'],( $_POST['id_uscita'] ?? []))?'selected':'';
                                        echo "<option {$selected} value=\"{$enum['id']}\">{$enum['uscita']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<div class="accordion p-1" id="filter_id_indirizzato_a">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_id_indirizzato_a" aria-expanded="false" aria-controls="collapse_filter_id_indirizzato_a">
                    Indirizzato a
                    </button>
                </h2>
                <div id="collapse_filter_id_indirizzato_a" class="accordion-collapse collapse" data-bs-parent="#filter_id_indirizzato_a">
                    <div class="accordion-body">
                        <div>
                            <label for="id_indirizzato_a">Indirizzato a</label>
                            <select class="form-control selectpicker" id="id_indirizzato_a" value="<?php echo $_POST['id_indirizzato_a'] ?? ''; ?>" multiple>
                                <?php 
                                    foreach (Select('*')->from('uscite_indirizzato_a')->get() as $enum) {
                                        $selected = in_array($enum['id'],( $_POST['id_indirizzato_a'] ?? []))?'selected':'';
                                        echo "<option {$selected} value=\"{$enum['id']}\">{$enum['indirizzato_a']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<div class="accordion p-1" id="filter_in_capo_a">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_in_capo_a" aria-expanded="false" aria-controls="collapse_filter_in_capo_a">
                    in capo a
                    </button>
                </h2>
                <div id="collapse_filter_in_capo_a" class="accordion-collapse collapse" data-bs-parent="#filter_in_capo_a">
                    <div class="accordion-body">
                        <div>
                            <label for="in_capo_a">In capo a</label>
                            <select class="form-control selectpicker" id="in_capo_a" value="<?php echo $_POST['in_capo_a'] ?? ''; ?>" multiple>
                                <?php 
                                    foreach (Enum('uscite_registrate','in_capo_a')->get() as $enum) {
                                        $selected = in_array($enum,( $_POST['in_capo_a'] ?? []))?'selected':'';
                                        echo "<option {$selected} value=\"{$enum}\">{$enum}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<div class="accordion p-1" id="filter_tipo_pagamento">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_tipo_pagamento" aria-expanded="false" aria-controls="collapse_filter_tipo_pagamento">
                    Tipo pagamento
                    </button>
                </h2>
                <div id="collapse_filter_tipo_pagamento" class="accordion-collapse collapse" data-bs-parent="#filter_tipo_pagamento">
                    <div class="accordion-body">
                        <div>
                            <label for="tipo_pagamento">Tipo pagamento</label>
                            <select class="form-control selectpicker" id="tipo_pagamento" value="<?php echo $_POST['tipo_pagamento'] ?? ''; ?>" multiple>
                                <?php 
                                    foreach (Enum('uscite_registrate','tipo_pagamento')->get() as $enum) {
                                        $selected = in_array($enum,( $_POST['tipo_pagamento'] ?? []))?'selected':'';
                                        echo "<option {$selected} value=\"{$enum}\">{$enum}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<div class="accordion p-1" id="filter_voucher">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_voucher" aria-expanded="false" aria-controls="collapse_filter_voucher">
                    Voucher
                    </button>
                </h2>
                <div id="collapse_filter_voucher" class="accordion-collapse collapse" data-bs-parent="#filter_voucher">
                    <div class="accordion-body">
                        <div>
                            <label for="voucher">Voucher</label>
                            <select class="form-control selectpicker" id="voucher" value="<?php echo $_POST['voucher'] ?? ''; ?>" multiple>
                                <?php 
                                    foreach (Enum('uscite_registrate','voucher')->get() as $enum) {
                                        $selected = in_array($enum,( $_POST['voucher'] ?? []))?'selected':'';
                                        echo "<option {$selected} value=\"{$enum}\">{$enum}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<div class="accordion p-1" id="filter_note">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_note" aria-expanded="false" aria-controls="collapse_filter_note">
                    Note
                    </button>
                </h2>
                <div id="collapse_filter_note" class="accordion-collapse collapse" data-bs-parent="#filter_note">
                    <div class="accordion-body">
                        <div>
                            <label for="note">Note</label>
                            <input class="form-control" id="note" value="<?php echo $_POST['note'] ?? ''; ?>" />
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