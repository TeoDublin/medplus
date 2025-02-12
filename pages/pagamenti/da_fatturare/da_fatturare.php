<?php style('pages/pagamenti/da_fatturare/da_fatturare.css'); ?><?php 
function has_filters(){
    return $_REQUEST['id_cliente']||$_REQUEST['origine'];
}
$where='vp.non_fatturato > 0';
$url='pagamenti.php';
if(has_filters()){
    $url.='?skip_cookie=true&';
    if($_REQUEST['id_cliente']){
        $where.=" AND id_cliente = {$_REQUEST['id_cliente']}";
        $url.="id_cliente={$_REQUEST['id_cliente']}&";
    }
    if($_REQUEST['origine']){
        $where.=" AND origine = '{$_REQUEST['origine']}'";
        $url.="origine={$_REQUEST['origine']}&";
    }
    $class='bg-light';
}
else $class='none';

$view_pagamenti = Select('vp.*,c.nominativo')
    ->from('view_pagamenti','vp')
    ->left_join('clienti c ON vp.id_cliente = c.id')
    ->where($where)
    ->get_table();?>

<div class="filter-labels d-flex flex-row align-items-center <?php echo $class;?> p-2"><?php
    if(has_filters()){?>
        <span class="fw-bold">FILTRI APPLICATI:</span>
        <?php if($_REQUEST['id_cliente']) echo "<div class=\"filter-label bg-colorfull2\"><span >Cliente: ".Select('*')->from('clienti')->where("id={$_REQUEST['id_cliente']}")->col('nominativo')."</span></div>"; ?>
        <?php if($_REQUEST['origine']) echo "<div class=\"filter-label bg-tertiary\"><span >Tipo: {$_REQUEST['origine']}</span></div>"; ?>
        <button class="btn btn-secondary ms-2" onclick="btnClean()">Pulisci Filtri</button><?php
    }?>
</div>

<?php 
    if(!$view_pagamenti->result){?>
        <div class="card card-body w-100 mt-3 text-center"><h5>Non trovato</h5></div><?php
    }
    else{?>
        <div class="w-100 mx-1" id="da_fatturare">
            <table class="table table-striped table-hover text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Tipo</th>
                        <th>Pendenza</th>
                        <th>Scadenza</th>
                        <th>Prezzo Tabellare</th>
                        <th>Prezzo</th>
                        <th>Saldato</th>
                        <th>Fatturato</th>
                        <th>Non Fatturato</th>
                    </tr>
                </thead>
                <tbody><?php 
                    foreach($view_pagamenti->result as $non_fatturato){?>
                        <tr>
                            <td><input type="checkbox" class="form-check"/></td>
                            <td><?php echo $non_fatturato['nominativo']; ?></td>
                            <td><?php echo $non_fatturato['origine']; ?></td>
                            <td><?php echo $non_fatturato['nome']; ?></td>
                            <td><?php echo unformat_date($non_fatturato['scadenza']); ?></td>
                            <td><?php echo $non_fatturato['prezzo_tabellare']; ?></td>
                            <td><?php echo $non_fatturato['prezzo']; ?></td>
                            <td><?php echo $non_fatturato['saldato']; ?></td>
                            <td><?php echo $non_fatturato['fatturato']; ?></td>
                            <td><?php echo $non_fatturato['non_fatturato']; ?></td>
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

<?php Html()->pagination($view_pagamenti,$url); ?>
<div class="floating-menu-btn">
    <button class="h-100 left"><?php echo icon('arrow-filled-left.svg'); ?></button>
    <button class="h-100 right"><?php echo icon('arrow-filled-right.svg'); ?></button>
</div>


<div class="floating-menu text-center">
    <div class="content p-0 h-100">
        <div class="pt-3 p-2">
            <h6>FILTRA SEZIONE</h6>
        </div>
        <div class="p-2 card-body m-2 bg-light rounded">
            <label class="form-label" for="id_cliente">Cliente</label>
            <select class="form-control" name="id_cliente" id="id_cliente">
                <option value=""></option>
                <?php foreach(Select('*')->from('clienti')->get() as $cliente) echo "<option value=\"{$cliente['id']}\">{$cliente['nominativo']}</option>"; ?>
            </select>
        </div>
        <div class="p-2 card-body m-2 bg-light rounded">
            <label class="form-label" for="origine">Tipo</label>
            <select class="form-control" name="origine" id="origine">
                <option value=""></option>
                <option value="Trattamenti">Trattamenti</option>
                <option value="Corsi">Corsi</option>
            </select>
        </div>
    </div>
    <div class="sticky-bottom w-100" onclick="btnFiltra()">
        <button class="btn btn-primary w-100">Filtra</button>
    </div>
</div>

<?php script('pages/pagamenti/da_fatturare/da_fatturare.js'); ?>