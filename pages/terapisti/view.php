
<div class="d-flex w-100 py-3">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('elenco')?'active':'';?>" aria-current="page" href="terapisti.php?tab=elenco&pagination=0">Terapisti</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('sedute')?'active':'';?>" aria-current="page" href="terapisti.php?tab=sedute&pagination=0">Storico Sedute</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('pagamenti')?'active':'';?>" aria-current="page" href="terapisti.php?tab=pagamenti&pagination=0">Pagamenti</a>
            </li>
        </ul>
        <div class="p-1">
            <?php 
                $tab=cookie('tab','elenco'); 
                require_once "{$tab}/{$tab}.php";?>
        </div>
    </div>
</div>