
<div class="d-flex w-100 py-3">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('anagrafica')?'active':'';?>" aria-current="page" href="clienti.php?tab=anagrafica&pagination=0">Anagrafica</a>
            </li>
        </ul>
        <div class="p-1">
            <?php $tab=cookie('tab','anagrafica');require "{$tab}/{$tab}.php";?>
        </div>
    </div>
</div>