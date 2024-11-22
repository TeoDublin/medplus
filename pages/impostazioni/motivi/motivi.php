<div class="d-flex flex-row p-2">
    <div class= "w-20" onclick="modal('');">
        <button type="button" class="btn btn-primary p-2 d-flex flex-row btn-insert w-100 h-100">
            <div class="mx-2"><?php echo icon('cloud-add.svg','white',20,20);?></div>
            <div>Aggiungi Motivo</div>
        </button>
    </div>
    <div class="">
        <div class="p-2 d-flex flex-row ms-3 w-100 bg-primary rounded">
            <div class="mx-2"><?php echo icon('search.svg','white',20,20);?></div>
            <input  placeholder="Cerca Motivo" class="input-search" value="<?php echo ($motivo=cookie('search',false))?$motivo:'';?>" />
            <button type="button" class="ms-2 w-100 btn-search" onclick="searchClick();">Cerca</button>
        </div>
    </div>
</div>
<div class="w-100 mx-1">
    <div class="card p">
        <?php
            $select=Select('*')->from('motivi','m')->limit(14)->orderby('m.id DESC');
            if($motivo)$select->where("m.motivo like '%{$motivo}%'");
            $table=$select->get_table();
        ?>
        <div class="card-body d-flex flex-column">
            <div class="p-2 border my-1" style="border-bottom: 0px!important;border-radius: 10px 10px 0 0;">
                <table class="table table-striped border-0">
                    <thead>
                        <tr class="align-middle">
                            <th scope="col" class="text-center" rowspan="2">Motivo</th>
                            <th scope="col" class="text-center" rowspan="2">#</th>
                        </tr>
                    </thead>
                    <tbody><?php
                        foreach ($table->result  as $row) {?>
                            <tr class="table-row" rowId="<?php echo $row['id'];?>" onclick="editClick(this);">
                                <td scope="col" class="text-center"><?php echo $row['motivo'];?></td>
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
<?php script('pages/impostazioni/motivi/motivi.js'); ?>