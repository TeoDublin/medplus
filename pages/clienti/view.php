
<div class="d-flex w-100 py-3">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('anagrafica')?'active':'';?>" aria-current="page" href="clienti.php?tab=anagrafica&pagination=0">Anagrafica</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('storico_sedute')?'active':'';?>" aria-current="page" href="clienti.php?tab=storico_sedute&pagination=0">Storico Sedute</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('storico_pagamenti')?'active':'';?>" aria-current="page" href="clienti.php?tab=storico_pagamenti&pagination=0">Storico Pagamenti</a>
            </li>
        </ul>
        <div class="p-1">
            <?php $tab=cookie('tab','anagrafica');require "{$tab}/{$tab}.php";?>
        </div>
    </div>
</div>