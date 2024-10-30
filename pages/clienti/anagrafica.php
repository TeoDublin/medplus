<?php if(cookie('rowId',false))$edit=Clienti()->first(['id'=>cookie('rowId',false)]); ?>
<div class="d-flex flex-row p-2">
    <div class="w-15">
        <button type="button" class="btn btn-primary p-2 d-flex flex-row modal-open w-100 h-100">
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
<div class="modal fade modal-xl" id="clienteModal" tabindex="-1" aria-labelledby="clienteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="clienteModalLabel"><?php echo cookie('rowId',false)?'Modifica Cliente':'Aggiungi Cliente';?></h1>
                <button type="button" class="btn-close btn-modal-cancel" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="clienti.php?tab=anagrafica&rowId=unset&openModal=unset&action=<?php echo cookie('rowId',false)?'update':'insert';?>" method="post">
                    <div class="mb-3" hidden="true">
                        <label for="modificaid" class="form-label">ID</label>
                        <input type="text" class="form-control" id="modificaid" name="id" value="<?php echo $edit['id']??'';?>">
                    </div> 
                    <div class="d-flex flex-row">
                        <div class="mb-3 w-35">
                            <label for="modalNominativo" class="form-label">Nominativo</label>
                            <input type="text" class="form-control" id="modalNominativo" name="nominativo" value="<?php echo $edit['nominativo']??'';?>">
                        </div>
                        <div class="mb-3 ms-2">
                            <label for="modalCf" class="form-label">CF/PIVA</label>
                            <input type="text" class="form-control" id="modalCf" name="cf" value="<?php echo $edit['cf']??'';?>">
                        </div>
                        <div class="mb-3 ms-2">
                            <label for="modalTelefono" class="form-label">Telefono</label>
                            <input type="text" class="form-control" id="modalTelefono" name="telefono" value="<?php echo $edit['telefono']??'';?>">
                        </div>
                        <div class="mb-3 ms-2">
                            <label for="modalCelulare" class="form-label">Celulare</label>
                            <input type="text" class="form-control" id="modalCelulare" name="celulare" value="<?php echo $edit['celulare']??'';?>">
                        </div>
                        <div class="mb-3 ms-2">
                            <label for="modalEmail" class="form-label">Email</label>
                            <input type="text" class="form-control" id="modalEmail" name="email" value="<?php echo $edit['email']??'';?>">
                        </div>                        
                    </div>               
                    <div class="d-flex flex-row">
                        <div class="mb-3 flex-fill">
                            <label for="modalIndirizzo" class="form-label">Indirizzo</label>
                            <input type="text" class="form-control" id="modalIndirizzo" name="indirizzo" value="<?php echo $edit['indirizzo']??'';?>">
                        </div>
                        <div class="mb-3 ms-2">
                            <label for="modalCap" class="form-label">CAP</label>
                            <input type="text" class="form-control" id="modalCap" name="cap" value="<?php echo $edit['cap']??'';?>">
                        </div>
                        <div class="mb-3 ms-2">
                            <label for="modalCitta" class="form-label">Città</label>
                            <input type="text" class="form-control" id="modalCitta" name="citta" value="<?php echo $edit['citta']??'';?>">
                        </div>
                        <div class="mb-3 ms-2">
                            <label for="modalTipo" class="form-label">Tipo</label>
                            <select type="text" class="form-control" id="modalTipo" name="tipo" value="<?php echo $edit['tipo']??'';?>">
                                <?php 
                                    foreach(Clienti()->enum('tipo') as $value){
                                        echo "<option>{$value}</option>";
                                    }
                                ?>
                            </select>
                        </div>                        
                    </div>
                    <div class="d-flex flex-row">
                        <div class="mb-3">
                            <label for="modalPortato_da" class="form-label">Portato da</label>
                            <input type="text" class="form-control" id="modalPortato_da" name="portato_da" value="<?php echo $edit['portato_da']??'';?>">
                        </div>
                        <div class="mb-3 ms-2">
                            <label for="modalData_inserimento" class="form-label">Data Inserimento</label>
                            <input disabled type="text" class="form-control" id="modalData_inserimento" name="data_inserimento" value="<?php echo $edit['data_inserimento']??now('d/m/Y');?>">
                        </div>
                        <div class="mb-3 ms-2 flex-fill">
                            <label for="modalPrestazioni_precedenti" class="form-label">Prestazioni precedenti</label>
                            <input type="text" class="form-control" id="modalPrestazioni_precedenti" name="prestazioni_precedenti" value="<?php echo $edit['prestazioni_precedenti']??'';?>">
                        </div>
                    </div>
                    <div class="d-flex flex-row">
                        <div class="mb-3 flex-fill">
                            <label for="modalNotizie_cliniche" class="form-label">Notizie_cliniche</label>
                            <textarea rows="3" class="form-control" id="modalNotizie_cliniche" name="notizie_cliniche" value="<?php echo $edit['notizie_cliniche']??'';?>"></textarea>
                        </div>
                        <div class="mb-3 ms-2 w-50">
                            <label for="modalNote_trattamento" class="form-label">Note trattamento</label>
                            <textarea rows="3" class="form-control" id="modalNote_trattamento" name="note_trattamento" value="<?php echo $edit['note_trattamento']??'';?>"></textarea>
                        </div>   
                    </div>                                             
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-modal-cancel" data-bs-dismiss="modal">Annulla</button>
                        <button type="submit" name="submit" class="btn btn-primary"><?php echo cookie('rowId',false)?"Modifica":"Aggiungi";?></button>
                    </div>                                        
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="eliminaClienteModal" tabindex="-1" aria-labelledby="eliminaClienteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="eliminaClienteModalLabel">Sicuro di voler eliminare ?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="clienti.php?tab=anagrafica&action=delete" method="post">
                    <div class="mb-3" hidden="true">
                        <label for="Elimina" class="form-label">ID</label>
                        <input type="text" class="form-control" id="EliminaId" name="id">
                    </div>
                    <div class="mb-3">
                        <label for="EliminaCliente" class="form-label">Cliente</label>
                        <input type="text" class="form-control" id="EliminaCliente" name="cliente" disabled>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                        <button type="submit" name="submit" class="btn btn-primary">Elimina</button>
                    </div>                                        
                </form>
            </div>
        </div>
    </div>
</div>
<div class="w-100 mx-1">
    <div class="card p">
        <?php 
            $parmas=['limit'=>6,'orderby'=>'id DESC'];
            if($nominativo=cookie('nominativo',false))$params['nominativo']=['like'=>"%{$nominativo}%"];
            $table=Clienti()->select_for_table($params);?>
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
            <script>
                const actions = {
                    btnSearch: document.querySelector('.btn-search'),
                    btnInsert: document.querySelector('.modal-open'),
                    rowEdit: document.querySelectorAll('.table-row'),
                    delList: document.querySelectorAll('.action-Elimina'),
                    btnModal: document.querySelector('.btn-modal-cancel'),
                    iconDel: document.querySelectorAll('.action-Elimina'),
                    searchInput: document.querySelector('.input-search'),
                    listen: function(){
                        const delClick = function(){
                            event.stopPropagation();
                            if(confirm('Sicuro di voler Eliminare?')){
                                let id = this.closest('tr').getAttribute('rowId');
                                $.ajax({
                                    url: window.location.href,
                                    type: 'POST',
                                    data: { submit:true, action: 'delete', id: id},
                                    error: function(xhr, status, error) { console.error(error);},
                                    success: function(response){
                                        window.location.href = window.location.href;
                                    }
                                });
                            }
                        };
                        const insertClick=function(){
                            let id = 'unset';
                            $.ajax({
                                url: window.location.href,
                                type: 'GET',
                                data: { rowId: id, openModal:true},
                                error: function(xhr, status, error) { console.error(error);},
                                success:function(){
                                    window.location.href=window.location.href;
                                }
                            });
                        };
                        const editClick=function(){
                            let id = this.getAttribute('rowId');
                            $.ajax({
                                url: window.location.href,
                                type: 'GET',
                                data: { rowId: id, openModal:true},
                                error: function(xhr, status, error) { console.error(error);},
                                success:function(){
                                    window.location.href=window.location.href;
                                }
                            });
                        };
                        const btnModalClick=function(){
                            $.ajax({
                                url: window.location.href,
                                type: 'GET',
                                data: { rowId: 'unset', openModal:'unset'},
                                error: function(xhr, status, error) { console.error(error);},
                                success:function(){
                                    window.location.href=window.location.href;
                                }
                            });
                        };
                        const hoverIconDel = function() {
                            const row = this.closest('tr');
                            row.classList.add('warning');
                            this.addEventListener('mouseleave', function() {
                                row.classList.remove('warning');
                            });
                        };
                        const btnSearchClick = function(){
                            let search = document.querySelector('.input-search').value;
                            if(search==''){
                                search='unset';
                            }
                            $.ajax({
                                url: window.location.href,
                                type: 'GET',
                                data: { nominativo: search},
                                error: function(xhr, status, error) { console.error(error);},
                                success:function(){
                                    window.location.href=window.location.href;
                                }
                            });
                        };
                        this.searchInput.addEventListener('keydown', function(event) {
                            if (event.key === 'Enter') {
                                btnSearchClick();
                            }
                        });                        
                        this.btnInsert.addEventListener('click', insertClick);
                        this.rowEdit.forEach(function(item){ item.addEventListener('click', editClick);});
                        this.delList.forEach(function(item){ item.addEventListener('click', delClick); });
                        this.iconDel.forEach(function(item){ item.addEventListener('mouseenter', hoverIconDel); });
                        this.btnModal.addEventListener('click',btnModalClick);
                        this.btnSearch.addEventListener('click',btnSearchClick);
                    },
                };
                actions.listen();
                <?php if(cookie('openModal',false)) echo "openModal('clienteModal');"?>
            </script>
        </div>
        <?php html()->pagination($table);?>
    </div>
</div>