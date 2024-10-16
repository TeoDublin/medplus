
<div class="d-flex w-100 py-3">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('trattamenti')?'active':'';?>" aria-current="page" href="elenchi.php?tab=trattamenti">Trattamenti</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('terapisti')?'active':'';?>" href="elenchi.php?tab=terapisti" aria-current="page">Terapisti</a>
            </li>
        </ul>
        <div class="p-1">
            <?php  require _tab_name().'.php';?>
        </div>
    </div>
</div>
