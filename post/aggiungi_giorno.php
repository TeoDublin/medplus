<?php require_once __DIR__.'/../includes.php'; ?>
<div class="flex-fill"><?php
    echo "<select class=\"form-control text-center\" name=\"giorno\" value=\"{$_REQUEST['giorno']}\">";
        foreach(Enum('corsi_giorni','giorno')->list as $enum){
            $selected = $_REQUEST['giorno']==$enum?'selected':'';
            echo "<option value=\"{$enum}\" {$selected}>{$enum}</option>";
        }
    echo "</select>";?>
</div>
<div class="w-30 mx-2"><input class="form-control text-center" type="time" value="<?php echo $_REQUEST['ora']??'08:00';?>"/></div>
<div class="w-10 pt-1" 
    onclick="hoveredwindow.modalHandlers['corsi_elenco'].delClick(this);"
    onmouseenter="hoveredwindow.modalHandlers['corsi_elenco'].delEnter(this);"
    onmouseleave="hoveredwindow.modalHandlers['corsi_elenco'].delLeave(this);"
><?php echo icon('bin.svg'); ?></div>