
<div class="py-3">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('registrate')?'active':'';?>" aria-current="page" href="uscite.php?tab=registrate&pagination=0">Registrate</a>
            </li>
        </ul>
        <div class="p-1">
            <?php 
                $tab=cookie('tab','registrate'); 
                require_once "{$tab}/{$tab}.php";
            ?>
        </div>
    </div>
</div>