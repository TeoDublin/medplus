<div class="d-flex flex-row p-2">
    <div class="">
        <div class="p-2 d-flex flex-row w-100 bg-primary rounded">
            <div class="mx-2"><?php echo icon('search.svg','white',20,20);?></div>
            <input  placeholder="Cerca Cliente" class="input-search" value="<?php echo ($nominativo=cookie('search',false))?$nominativo:'';?>" />
            <button type="button" class="ms-2 w-100 btn-search" onclick="searchClick();">Cerca</button>
        </div>   
    </div>
</div>
<div class="w-100 mx-1">
    <div class="card p">
        <?php 
            $select=Select('*percorsi*,*clienti*')
                ->from('percorsi','p')
                ->left_join('clienti c ON p.id_cliente = c.id')
                ->limit(14)->orderby('c.id DESC');
            if($nominativo){
                $nominativo=str_replace("'","\'",$nominativo);
                $select->where("c.nominativo like '%{$nominativo}%'");
            }
            $table=$select->get_table();
        ?>
        <div class="card-body d-flex flex-column">
            <div class="p-2 border my-1" style="border-bottom: 0px!important;border-radius: 10px 10px 0 0;">
                <table class="table table-striped border-0">
                    <thead>
                        <tr class="align-middle">
                            <th scope="col" class="text-center" rowspan="2">Nominativo</th>
                            <th scope="col" class="text-center" rowspan="2">Percorso</th>
                            <th scope="col" class="text-center" rowspan="2">Stato Sedute</th>
                            <th scope="col" class="text-center" rowspan="2">Stato Pagamenti</th>
                            <th scope="col" class="text-center" rowspan="2">Note</th>
                            <th scope="col" class="text-center" rowspan="2">#</th>
                        </tr>
                    </thead>
                    <tbody><?php
                        foreach ($table->result  as $row) {?>
                            <tr class="table-row" rowId="<?php echo $row['id'];?>" onclick="editClick(this);">
                                <td scope="col" class="text-center"><?php echo $row['nominativo'];?></td>
                                <td scope="col" class="text-center"><?php echo $row['percorso'];?></td>
                                <td scope="col" class="text-center"><?php echo $row['stato_sedute'];?></td>
                                <td scope="col" class="text-center"><?php echo $row['stato_pagamenti'];?></td>
                                <td scope="col" class="text-center"><?php echo $row['note'];?></td>
                                <td scope="col" class="text-center action-Elimina" title="Elimina" onclick="delClick(this);" onmouseenter="hoverIconWarning(this)";><?php echo icon('bin.svg');?></td>
                            </tr><?php
                        }?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php html()->pagination($table);?>
    </div>
</div>
<div id="trattamenti"></div>
<?php script('pages/clienti/percorsi/percorsi.js'); ?>