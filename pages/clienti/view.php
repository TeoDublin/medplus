
<div class="py-3">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('anagrafica')?'active':'';?>" aria-current="page" href="clienti.php?tab=anagrafica&pagination=0">Anagrafica</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('storico')?'active':'';?>" aria-current="page" href="clienti.php?tab=storico&pagination=0">Storico</a>
            </li>
        </ul>
        <div class="p-1">
            <?php $tab=cookie('tab','anagrafica');require_once "{$tab}/{$tab}.php";?>
        </div>
    </div>
</div>