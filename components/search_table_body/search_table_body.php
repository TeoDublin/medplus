<?php
    $response=json_decode($_REQUEST['response']);
    if($response->total==0)echo "<div class=\"text-center mt-3\"><h3>Non Trovato</h3></div>";
    else{
        foreach ($response->result  as $row) {?>
            <tr class="table-row" onclick="editClick(this,<?php echo $row->id;?>);">
                <?php foreach ($response->cols as $col)if($col!='id')echo "<td scope=\"col\" class=\"text-center\">{$row->{$col}}</td>";
                if($response->actions){
                    foreach (json_decode($response->actions) as $key => $value) {
                        switch ($value) {
                            case 'success':{
                                echo "<td scope=\"col\" class=\"text-center hover-icon\" title=\"{$key}\" onmouseenter=\"hoverIconAdd(this,'success')\";>".icon('heart.svg')."</td>";
                                break;
                            }
                            case 'success2':{
                                echo "<td scope=\"col\" class=\"text-center hover-icon\" title=\"{$key}\" onmouseenter=\"hoverIconAdd(this,'success2')\";>".icon('people-arms.svg')."</td>";
                                break;
                            }
                            case 'success3':{
                                echo "<td scope=\"col\" class=\"text-center hover-icon\" title=\"{$key}\" onmouseenter=\"hoverIconAdd(this,'success3')\";>".icon('dollar.svg')."</td>";
                                break;
                            }
                        }
                    }   
                }?>
                <td scope="col" class="text-center action-Elimina" title="Elimina" 
                    onmouseenter="hoverIconWarning(this)";><?php echo icon('bin.svg');?>
                </td>
            </tr><?php
        }
    }
?>