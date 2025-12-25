
<div class="py-3">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('registrate')?'active':'';?>" aria-current="page" href="uscite.php?<?php echo unset_default(['tab'=>'registrate']);?>">Registrate</a>
            </li>
        </ul>
        <div class="p-1">
            <?php 
                require_once "{$tab}/{$tab}.php";
            ?>
        </div>
    </div>
</div>