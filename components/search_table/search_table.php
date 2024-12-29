<?php
    $select=Select('*')->from($_REQUEST['table'])->limit(14)->orderby('id DESC');
    if($_REQUEST['search'])$select->where("{$_REQUEST['search']['key']} like '%{$_REQUEST['search']['value']}%'");
    $table=$select->get_table();
    $cols=$_REQUEST['cols']??array_keys(array_diff_key($table->result[0]??[],['id'=>1]));
?>
<div class="card p">
    <div class="card-body d-flex flex-column">
        <div class="p-2 border my-1" style="border-bottom: 0px!important;border-radius: 10px 10px 0 0;"><?php 
            if($table->total==0)echo "<div class=\"text-center mt-3\"><h3>Non Trovato</h3></div>";
            else{?>
                <table class="table table-striped border-0">
                    <thead>
                        <tr class="align-middle"><?php 
                            foreach ($cols as $col) if($col!='id')echo "<th scope=\"col\" class=\"text-center\" rowspan=\"2\">{$col}</th>";
                            foreach ($_REQUEST['actions']??[] as $key=>$value)echo "<th scope=\"col\" class=\"text-center\" rowspan=\"2\">{$key}</th>";?>
                            <th scope="col" class="text-center" rowspan="2">#</th>
                        </tr>
                    </thead>
                    <tbody><?php
                        foreach ($table->result  as $row) {?>
                            <tr class="table-row" onclick="editClick(this,<?php echo $row['id'];?>);">
                                <?php foreach ($cols as $col)if($col!='id')echo "<td scope=\"col\" class=\"text-center\">{$row[$col]}</td>";
                                foreach ($_REQUEST['actions']??[] as $key => $value) {
                                    switch ($value) {
                                        case 'success':{
                                            echo "<td scope=\"col\" class=\"text-center hover-icon\" title=\"{$key}\" onmouseenter=\"hoverIconAdd(this,'success')\";>".icon('heart.svg')."</td>";
                                            break;
                                        }
                                        case 'success2':{
                                            echo "<td scope=\"col\" class=\"text-center hover-icon\" title=\"{$key}\" onmouseenter=\"hoverIconAdd(this,'success2')\";>".icon('dollar.svg')."</td>";
                                            break;
                                        }
                                    }
                                }                                
                                ?>
                                <td scope="col" class="text-center action-Elimina" title="Elimina" 
                                    onmouseenter="hoverIconWarning(this)";><?php echo icon('bin.svg');?>
                                </td>
                            </tr><?php
                        }?>
                    </tbody>
                </table><?php 
            };?>
        </div>
    </div>
    <?php html()->pagination($table);?>
</div>
