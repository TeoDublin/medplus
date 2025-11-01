<?php 
    require_once '../../includes.php';
    function _has_filters(){
        return count($_POST)>0&&!isset($_REQUEST['btnClean']);
    }
    $where='1=1';
    $url='pagamenti.php';
    if(_has_filters()){
        if($_POST['data']['all']);
        else{
            if($_POST['data']['da'])$where.=" AND `data` >='{$_POST['data']['da']}'";
            if($_POST['data']['a'])$where.=" AND `data` <='{$_POST['data']['a']}'";    
        }
        if($_POST['id_uscita'])$where.=" AND id_uscita ='{$_POST['id_uscita']}'";
    }
    elseif(isset($_REQUEST['btnClean']));
    else{
        $_POST['data']['da']=date('Y-m-01');
        $_POST['data']['a']=date('Y-m-d');
        $where.=" AND data >='{$_POST['data']['da']}' AND data <='{$_POST['data']['a']}'";
    }
    $view_uscite = Select('*')->from('view_uscite')->where($where)->orderby('data ASC')->get_table();
    $somma_importo= number_format(Select("sum(importo) as importo")->from('view_uscite')->where($where)->col('importo'),2);
?>

<!-- where -->
<div class="filter-labels d-flex flex-row align-items-center bg-light p-2 w-100">
    <span class="fw-bold">FILTRI APPLICATI:</span>
    <?php
    if(_has_filters()){?>
        <?php
            if(isset($_POST['data']['all']));
            else{
                if($_POST['data']['da']) echo "<div class=\"filter-label bg-gray\"><span >Seduta Da: ".unformat_date($_POST['data']['da'])."</span></div>"; 
                if($_POST['data']['a']) echo "<div class=\"filter-label bg-gray\"><span >Seduta A: ".unformat_date($_POST['data']['a'])."</span></div>";    
            } 
            if($_POST['nome']) echo "<div class=\"filter-label bg-gray\"><span >Uscita: {$_POST['nome']}</span></div>";
        ?>
        <button class="btn btn-secondary ms-2" onclick="btnClean()">Pulisci Filtri</button><?php
    }
    ?>
    <button class="btn btn-secondary ms-2 ms-auto" onclick="aggiungiUscita()">Aggiungi Uscita</button>
</div>
<div>
    <span><?php echo "Quantità: {$view_uscite->total}, Somma: € {$somma_importo}"; ?></span>
</div>

<!-- table -->
<?php 
    if(!$view_uscite->result){?>
        <div class="card card-body mt-3 text-center"><h5>Non trovato</h5></div><?php
    }
    else{?>
        <div class="px-1">
            <table class="table table-striped table-hover text-center">
                <thead>
                    <tr class="small">
                        <th>Data</th>
                        <th>Importo</th>
                        <th>Uscita</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody><?php 
                    foreach($view_uscite->result as $uscita){?>
                        <tr data-id=<?php echo $uscita['id']; ?> style="font-size:12px;line-height:8px; word-break:break-word;" >
                            <td onmouseenter="enterEdit(this)" onmouseleave="leaveEdit(this)" onclick="clickEdit(<?php echo $uscita['id']; ?>)"><?php echo $uscita['data']?unformat_date($uscita['data']):'-'; ?></td>
                            <td onmouseenter="enterEdit(this)" onmouseleave="leaveEdit(this)" onclick="clickEdit(<?php echo $uscita['id']; ?>)"><?php echo number_format($uscita['importo'],2); ?></td>
                            <td onmouseenter="enterEdit(this)" onmouseleave="leaveEdit(this)" onclick="clickEdit(<?php echo $uscita['id']; ?>)"><?php echo $uscita['nome']; ?></td>
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
<?php Html()->pagination2($view_uscite,$url); ?>

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
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_data" aria-expanded="false" aria-controls="collapse_filter_data">
                    Data Uscita
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
        <div class="accordion p-1" id="filter_nome">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_nome" aria-expanded="false" aria-controls="collapse_filter_nome">
                    Uscita
                    </button>
                </h2>
                <div id="collapse_filter_nome" class="accordion-collapse collapse" data-bs-parent="#filter_nome">
                    <div class="accordion-body">
                        <div>
                            <label for="nome">Uscita</label>
                            <select class="form-control" id="nome" value="<?php echo $_POST['id_uscita']; ?>">
                                <option value="">Tutti</option>
                                <?php 
                                    foreach (Select('*')->from('uscite')->orderby('nome ASC')->get() as $enum) {
                                        $selected=$_POST['id_uscita']&&$_POST['id_uscita']==$enum['id']?'selected':'';
                                        echo "<option {$selected} value=\"{$enum['id']}\">{$enum['nome']}</option>";
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