<?php require_once __DIR__.'/../includes.php'; ?>
<div class="flex-fill"><?php
    echo "<select class=\"form-control text-center cliente\" value=\"{$_REQUEST['cliente']}\">";
        foreach(Select('*')->from('clienti')->get() as $enum){
            $selected = $_REQUEST['id_cliente']==$enum['id']?'selected':'';
            echo "<option value=\"{$enum['id']}\" {$selected}>{$enum['nominativo']}</option>";
        }
    echo "</select>";?>
</div>
<div class="w-30 mx-2"><input class="form-control text-center prezzo" type="number" value="<?php echo $_REQUEST['prezzo']??$_REQUEST['prezzo_tabellare'];?>"/></div>
<div class="w-10 pt-1 del-btn-cliente" ><?php echo icon('bin.svg'); ?></div>