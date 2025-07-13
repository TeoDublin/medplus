<?php 
    require_once '../../includes.php';
    function _has_filters(){
        return count($_POST)>0&&!isset($_REQUEST['btnClean']);
    }
    function _presenze_log($where){
        return Select('ut.*,u.nome as username')
            ->from('utenti_presenze','ut')
            ->left_join("utenti u ON ut.id_utenti = u.id")
            ->where($where)
            ->orderby('ut.id_utenti ASC, ut.data ASC, ut.orario')
            ->get_table();
    }
    $url='utenti.php';
    $where='1=1';
    if(_has_filters()){
        if($_POST['data']['all']);
        else{
            if($_POST['data']['da'])$where.=" AND `data` >='{$_POST['data']['da']}'";
            if($_POST['data']['a'])$where.=" AND `data` <='{$_POST['data']['a']}'";    
        }
        if(isset($_POST['id_utenti']))$where.=" AND id_utenti ='{$_POST['id_utenti']}'";
    }
    elseif(isset($_REQUEST['btnClean']));
    else{
        $_POST['data']['da']=date('Y-m-01');
        $_POST['data']['a']=date('Y-m-d');
        $where.=" AND `data` >='{$_POST['data']['da']}' AND `data` <='{$_POST['data']['a']}'";
    }
    $presenze_log = _presenze_log($where);
?>

<!-- where -->
<div class="filter-labels d-flex flex-row align-items-center bg-light p-2">
    <span class="fw-bold">FILTRI APPLICATI:</span>
    <?php
    if(_has_filters()){?>
        <?php
            if(isset($_POST['data']['all']));
            else{
                if($_POST['data']['da']) echo "<div class=\"filter-label bg-gray\"><span >Data Da: ".unformat_date($_POST['data']['da'])."</span></div>"; 
                if($_POST['data']['a']) echo "<div class=\"filter-label bg-gray\"><span >Data A: ".unformat_date($_POST['data']['a'])."</span></div>";    
            } 
            if(isset($_POST['id_utenti'])) echo "<div class=\"filter-label bg-gray\"><span >Uttente: {$_POST['username']}</span></div>";
        ?>
        <button class="btn btn-secondary ms-2" onclick="btnClean()">Pulisci Filtri</button><?php
    }
    ?>
</div>

<!-- table -->
<?php 
    if(!$presenze_log->result){?>
        <div class="card card-body mt-3 text-center"><h5>Non trovato</h5></div><?php
    }
    else{?>
        <div class="px-1">
            <table class="table table-striped table-hover text-center">
                <thead>
                    <tr class="small">
                        <th class="w-30">Utente</th>
                        <th class="w-15">Categoria</th>
                        <th class="w-20">Nome</th>
                        <th class="w-15">Data</th>
                        <th class="w-15">Orario</th>
                        <th class="w-5">#</th>
                    </tr>
                </thead>
                <tbody><?php 
                    foreach($presenze_log->result as $pl){?>
                        <tr data-id=<?php echo $pl['id']; ?> style="font-size:12px;line-height:8px; word-break:break-word;">
                            <td onmouseenter="editEnter(this)" onmouseleave="editLeave(this)" onclick="edit(<?php echo $pl['id']; ?>)"><?php echo $pl['username']; ?></td>
                            <td onmouseenter="editEnter(this)" onmouseleave="editLeave(this)" onclick="edit(<?php echo $pl['id']; ?>)"><?php echo $pl['categoria']; ?></td>
                            <td onmouseenter="editEnter(this)" onmouseleave="editLeave(this)" onclick="edit(<?php echo $pl['id']; ?>)"><?php echo $pl['nome']; ?></td>
                            <td onmouseenter="editEnter(this)" onmouseleave="editLeave(this)" onclick="edit(<?php echo $pl['id']; ?>)"><?php echo $pl['data']?format($pl['data'],'d/m/y'):'-'; ?></td>
                            <td onmouseenter="editEnter(this)" onmouseleave="editLeave(this)" onclick="edit(<?php echo $pl['id']; ?>)"><?php echo $pl['orario']; ?></td>
                            <td scope="col" class="text-center text-wrap action-Elimina" title="Elimina" 
                                onmouseenter="hoverIconWarning(this)"
                                onclick="del(<?php echo $pl['id']; ?>)"
                            ><?php echo icon('bin.svg');?>
                            </td>
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
<?php Html()->pagination2($presenze_log,$url); ?>

<!-- floating menu -->
<div class="floating-menu-btn">
    <button class="h-100 left"><?php echo icon('arrow-filled-left.svg'); ?></button>
    <button class="h-100 right"><?php echo icon('arrow-filled-right.svg'); ?></button>
</div>
<div class="floating-excel-btn" onclick="excel('post/excel_presenze_log.php')">
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
        <div class="accordion p-1" id="filter_id_utenti">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_user" aria-expanded="false" aria-controls="collapse_filter_user">
                    Utente
                    </button>
                </h2>
                <div id="collapse_filter_user" class="accordion-collapse collapse" data-bs-parent="#filter_id_utenti">
                    <div class="accordion-body">
                        <div>
                            <label for="id_utenti">Utente</label>
                            <select class="form-control" id="id_utenti" value="<?php echo $_POST['id_utenti']; ?>">
                                <option value="">Tutti</option>
                                <option value="0" <?= (isset($_POST['id_utenti']) && $_POST['id_utenti'] === "0") ? 'selected' : '' ?>>Non Assegnato</option>
                                <?php 
                                    foreach (Select('*')->from('utenti')->get() as $user) {
                                        $selected=$_POST['id_utenti']&&$_POST['id_utenti']==$user['id']?'selected':'';
                                        echo "<option {$selected} value=\"{$user['id']}\">{$user['username']}</option>";
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