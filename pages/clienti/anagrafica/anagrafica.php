<div class="d-flex flex-row p-2">
    <div class= "w-20" onclick="add(false);">
        <button type="button" class="btn btn-primary p-2 d-flex flex-row btn-insert w-100 h-100">
            <div class="mx-2"><?php echo icon('cloud-add.svg','white',20,20);?></div>
            <div>Aggiungi Cliente</div>
        </button>
    </div>
    <div class="">
        <div class="p-2 d-flex flex-row ms-3 w-100 bg-primary rounded">
            <div class="mx-2"><?php echo icon('search.svg','white',20,20);?></div>
            <input  placeholder="Cerca Cliente" class="input-search" value="<?php echo ($nominativo=cookie('search',false))?$nominativo:'';?>" />
            <button type="button" class="ms-2 w-100 btn-search" onclick="searchClick();">Cerca</button>
        </div>   
    </div>
</div>
<div class="w-100 mx-1">
    <div class="card p">
        <?php 
            $select=Select('*')->from('clienti','c')->limit(14)->orderby('c.id DESC');
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
                            <th scope="col" class="text-center" rowspan="2">CF/IVA</th>
                            <th scope="col" class="text-center" rowspan="2">cellulare</th>
                            <th scope="col" class="text-center" rowspan="2">Email</th>
                            <th scope="col" class="text-center" rowspan="2">Notizie Cliniche</th>
                            <th scope="col" class="text-center" rowspan="2">Percorso Terapeutico</th>
                            <th scope="col" class="text-center" rowspan="2">Pagamenti</th>
                            <th scope="col" class="text-center" rowspan="2">#</th>
                        </tr>
                    </thead>
                    <tbody><?php
                        foreach ($table->result  as $row) {?>
                            <tr class="table-row" onclick="editClick(this,<?php echo $row['id'];?>);">
                                <td scope="col" class="text-center"><?php echo $row['nominativo'];?></td>
                                <td scope="col" class="text-center"><?php echo $row['cf'];?></td>
                                <td scope="col" class="text-center"><?php echo $row['cellulare'];?></td>
                                <td scope="col" class="text-center"><?php echo $row['email'];?></td>
                                <td scope="col" class="text-center"><?php echo $row['notizie_cliniche'];?></td>
                                <td scope="col" class="text-center hover-icon" title="Percorsi" onmouseenter="hoverIconAdd(this,'success')";><?php echo icon('heart.svg');?></td>
                                <td scope="col" class="text-center hover-icon" title="Pagamenti" onmouseenter="hoverIconAdd(this,'success2')";><?php echo icon('dollar.svg');?></td>
                                <td scope="col" class="text-center hover-icon" title="Elimina" onmouseenter="hoverIconWarning(this,'warning')";><?php echo icon('bin.svg');?></td>
                            </tr><?php
                        }?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php html()->pagination($table);?>
    </div>
</div>
<div id='percorsi'></div>   
<?php script('pages/clienti/anagrafica/anagrafica.js'); ?>