<?php require_once __DIR__.'/../includes.php'; ?>
<div class="flex-fill"><?php
    echo "<select class=\"form-control text-center flex-fill cliente\" value=\"{$_REQUEST['cliente']}\">";
        echo "<option></option>";
        foreach(Select('*')->from('clienti')->get() as $enum){
            $selected = $_REQUEST['cliente']==$enum['id']?'selected':'';
            echo "<option value=\"{$enum['id']}\" {$selected}>{$enum['nominativo']}</option>";
        }
    echo "</select>";?>
</div>
<div class="w-15 mx-2"><input class="form-control text-center prezzo" type="number" value="<?php echo $_REQUEST['prezzo']??$_REQUEST['prezzo_tabellare'];?>"/></div>
<div class="w-15 mx-2"><input class="form-control text-center data_inizio" type="date" value="<?php echo $_REQUEST['data_inizio']??now('Y-m-d');?>"/></div>
<div class="w-20 mx-2"><?php
    
    $bnw = isset($_REQUEST['bnw']) ? $_REQUEST['bnw'] :'da definire';
    
    echo "<select class=\"form-control text-center flex-fill bnw\" value=\"{$_REQUEST['cliente']}\">";
        foreach(Enum('corsi_classi','bnw')->get() as $enum){
            $selected = $bnw ==$enum?'selected':'';
            echo "<option value=\"{$enum}\" {$selected}>{$enum}</option>";
        }
    echo "</select>";?>
</div>

<div class="w-20 mx-2"><?php 

    $realizzato_da  = isset($_REQUEST['realizzato_da']) ? $_REQUEST['realizzato_da'] :'Medplus';

    echo "<select class=\"form-control text-center realizzato_da\" name=\"realizzato_da\" value=\"{$realizzato_da}\">";
        foreach(Enum('corsi_classi','realizzato_da')->get() as $enum){
            $selected=$realizzato_da==$enum?'selected':'';
            echo "<option value=\"{$enum}\" {$selected}>{$enum}</option>";
        }
    echo "</select>";?>
</div>

<div class="w-10 pt-1 del-btn-cliente" ><?php echo icon('bin.svg'); ?></div>