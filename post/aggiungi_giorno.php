<?php require_once __DIR__.'/../includes.php'; ?>
<div class="flex-fill"><?php
    echo "<select class=\"form-control text-center px-0 giorno\" value=\"{$_REQUEST['giorno']}\">";
        foreach(Enum('corsi_giorni','giorno')->list as $enum){
            $selected = $_REQUEST['giorno']==$enum?'selected':'';
            echo "<option value=\"{$enum}\" {$selected}>{$enum}</option>";
        }
    echo "</select>";?>
</div>
<div class="w-10 ms-2"><?php
    echo "<select class=\"form-control text-center px-0 inizio\" value=\"{$_REQUEST['inizio']}\">";
        foreach(Select("id,TIME_FORMAT(ora, '%H:%i') as ora")->from('planning_row')->get() as $enum){
            $selected = $_REQUEST['inizio']==$enum['id']?'selected':'';
            echo "<option value=\"{$enum['id']}\" {$selected}>{$enum['ora']}</option>";
        }
    echo "</select>";?>
</div>
<div class="w-10 ms-2"><?php
    echo "<select class=\"form-control text-center px-0 fine\" value=\"{$_REQUEST['fine']}\">";
    foreach(Select("id,TIME_FORMAT(ora, '%H:%i') as ora")->from('planning_row')->get() as $enum){
        $selected = $_REQUEST['fine']==$enum['id']?'selected':'';
        echo "<option value=\"{$enum['id']}\" {$selected}>{$enum['ora']}</option>";
    }
    echo "</select>";?>
</div>
<div class="w-5 pt-1 del-btn" ><?php echo icon('bin.svg'); ?></div>