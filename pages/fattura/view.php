
<div class="d-flex w-100 py-3">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('libera')?'active':'';?>" aria-current="page" href="impostazioni.php?tab=libera&pagination=0&rowId=unset">Libera</a>
            </li>
        </ul>
        <div class="p-1">
            <?php $tab=cookie('tab','libera'); require "{$tab}/{$tab}.php";?>
        </div>
    </div>
</div>