
<div class="py-3">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('sedute')?'active':'';?>" aria-current="page" href="pagamenti.php?tab=sedute&pagination=0">Sedute</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('fatture')?'active':'';?>" aria-current="page" href="pagamenti.php?tab=fatture&pagination=0">Fatture</a>
            </li>
        </ul>
        <div class="p-1">
            <?php $tab=cookie('tab','sedute'); require_once "{$tab}/{$tab}.php";?>
        </div>
    </div>
</div>