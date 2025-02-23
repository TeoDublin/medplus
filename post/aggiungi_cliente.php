<?php require_once __DIR__.'/../includes.php'; ?>
<div class="flex-fill"><?php
    echo "<select class=\"form-control text-center flex-fill cliente\" value=\"{$_REQUEST['cliente']}\">";
        foreach(Select('*')->from('clienti')->get() as $enum){
            $selected = $_REQUEST['cliente']==$enum['id']?'selected':'';
            echo "<option value=\"{$enum['id']}\" {$selected}>{$enum['nominativo']}</option>";
        }
    echo "</select>";?>
</div>
<div class="w-20 mx-2"><input class="form-control text-center prezzo" type="number" value="<?php echo $_REQUEST['prezzo']??$_REQUEST['prezzo_tabellare'];?>"/></div>
<div class="w-20 mx-2"><input class="form-control text-center data_inizio" type="date" value="<?php echo $_REQUEST['data_inizio']??now('Y-m-d');?>"/></div>
<div class="w-5 pt-1 del-btn-cliente" ><?php echo icon('bin.svg'); ?></div>