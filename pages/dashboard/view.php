
<div class="d-flex w-100 py-3">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('kpis')?'active':'';?>" aria-current="page" href="dashboard.php?tab=kpis&pagination=0">Dashboard</a>
            </li>
        </ul>
        <div class="p-1">
            <?php 
                $tab=cookie('tab','kpis'); 
                require_once "{$tab}/{$tab}.php";?>
        </div>
    </div>
</div>