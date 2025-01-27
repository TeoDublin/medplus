<?php require_once __DIR__.'/../includes.php'; ?>
<div class="flex-fill"><?php
    echo "<select class=\"form-control text-center giorno\" value=\"{$_REQUEST['giorno']}\">";
        foreach(Enum('corsi_giorni','giorno')->list as $enum){
            $selected = $_REQUEST['giorno']==$enum?'selected':'';
            echo "<option value=\"{$enum}\" {$selected}>{$enum}</option>";
        }
    echo "</select>";?>
</div>
<div class="w-30 mx-2"><input class="form-control text-center ora" type="time" value="<?php echo $_REQUEST['ora']??'08:00';?>"/></div>
<div class="w-10 pt-1 del-btn" ><?php echo icon('bin.svg'); ?></div>