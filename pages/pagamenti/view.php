
<div class="d-flex w-100 py-3">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('da_fatturare')?'active':'';?>" aria-current="page" href="pagamenti.php?tab=da_fatturare&pagination=0">Da Fatturare</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('fatturati')?'active':'';?>" aria-current="page" href="pagamenti.php?tab=fatturati&pagination=0">Fatturati</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('storico_pagamenti')?'active':'';?>" aria-current="page" href="pagamenti.php?tab=storico_pagamenti&pagination=0">Storico Pagamenti</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('fattura_libera')?'active':'';?>" aria-current="page" href="pagamenti.php?tab=fattura_libera&pagination=0">Fattura libera</a>
            </li>
        </ul>
        <div class="p-1">
            <?php $tab=cookie('tab','da_fatturare'); require_once "{$tab}/{$tab}.php";?>
        </div>
    </div>
</div>