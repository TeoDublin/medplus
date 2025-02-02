<?php
    $response=json_decode($_REQUEST['response']);
    $is_first=true;
    if($response->total==0)echo "<div class=\"text-center mt-3\"><h3>Non Trovato</h3></div>";
    else{
        foreach ($response->result  as $row) {
            $is_first=true;?>
            <tr class="table-row" onclick="editClick(this,<?php echo $row->id;?>);">
                <?php foreach ($response->cols as $col){
                    if($is_first&&$col!='id'){
                        $is_first=false;
                        $tr_class='';
                    }
                    else $tr_class='d-none d-md-table-cell';
                    if($col!='id')echo "<td scope=\"col\" class=\"text-center {$tr_class}\">{$row->{$col}}</td>";
                }
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
                            case 'success4':{
                                echo "<td scope=\"col\" class=\"text-center hover-icon\" title=\"{$key}\" onmouseenter=\"hoverIconAdd(this,'success4')\";>".icon('document.svg')."</td>";
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