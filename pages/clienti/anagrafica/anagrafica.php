<div class="d-flex flex-row p-2">
    <div class="w-20">
        <button type="button" class="btn btn-primary p-2 d-flex flex-row btn-insert w-100 h-100">
            <div class="mx-2"><?php echo icon('cloud-add.svg','white',20,20);?></div>
            <div>Aggiungi Cliente</div>
        </button>
    </div>
    <div class="">
        <div class="p-2 d-flex flex-row ms-3 w-100 bg-primary rounded">
            <div class="mx-2"><?php echo icon('search.svg','white',20,20);?></div>
            <input  placeholder="Cerca Cliente" class="input-search" value="<?php echo ($nominativo=cookie('nominativo',false))?$nominativo:'';?>" />
            <button type="button" class="ms-2 w-100 btn-search">Cerca</button>
        </div>   
    </div>
</div>
<div class="w-100 mx-1">
    <div class="card p">
        <?php 
            if($nominativo=cookie('nominativo',false))$params['nominativo']=['like'=>"%{$nominativo}%"];
            $table=Select('*')->from('clienti','c')->orderby('c.id DESC')->limit(14)->get_table();
        ?>
        <div class="card-body d-flex flex-column">
            <div class="p-2 border my-1" style="border-bottom: 0px!important;border-radius: 10px 10px 0 0;">
                <table class="table table-striped border-0">
                    <thead>
                        <tr class="align-middle">
                            <th scope="col" class="text-center" rowspan="2">Nominativo</th>
                            <th scope="col" class="text-center" rowspan="2">CF/IVA</th>
                            <th scope="col" class="text-center" rowspan="2">Celulare</th>
                            <th scope="col" class="text-center" rowspan="2">Notizie Cliniche</th>
                            <th scope="col" class="text-center" rowspan="2">Note Trattamento</th>
                            <th scope="col" class="text-center" rowspan="2">#</th>
                        </tr>
                    </thead>
                    <tbody><?php
                        foreach ($table->result  as $row) {?>
                            <tr class="table-row" rowId="<?php echo $row['id'];?>">
                                <td scope="col" class="text-center"><?php echo $row['nominativo'];?></td>
                                <td scope="col" class="text-center"><?php echo $row['cf'];?></td>
                                <td scope="col" class="text-center"><?php echo $row['celulare'];?></td>
                                <td scope="col" class="text-center"><?php echo $row['notizie_cliniche'];?></td>
                                <td scope="col" class="text-center"><?php echo $row['note_trattamento'];?></td>
                                <td scope="col" class="text-center action-Elimina" title="Elimina"><?php echo icon('bin.svg');?></td>
                            </tr><?php
                        }?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php html()->pagination($table);?>
    </div>
</div>
<?php script('pages/clienti/anagrafica/anagrafica.js'); ?>