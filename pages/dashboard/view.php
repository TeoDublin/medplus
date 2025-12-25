
<div class="d-flex w-100 py-3">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('pagamenti')?'active':'';?>" aria-current="page" href="dashboard.php?<?php echo unset_default(['tab'=>'pagamenti']);?>">Pagamenti</a>
            </li>
        </ul>
        <div class="p-1">
            <?php 
                $tab=cookie('tab','pagamenti'); 
                require_once "{$tab}/{$tab}.php";?>
        </div>
    </div>
</div>