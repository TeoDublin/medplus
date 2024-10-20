<?php if(cookie('rowId',false))$edit=Utenti()->first(['id'=>cookie('rowId',false)]); ?>
<div class="d-flex flex-row w-100 p-2">
    <button type="button" class="btn btn-primary p-2 d-flex flex-row modal-open">
        <div class="mx-2"><?php echo icon('cloud-add.svg','white',20,20);?></div>
        <div>Aggiungi Utente</div>
    </button>
</div>
<div class="modal fade" id="utenteModal" tabindex="-1" aria-labelledby="utenteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="utenteModalLabel"><?php echo cookie('rowId',false)?'Modifica Utente':'Aggiungi Utente';?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="utenti.php?tab=anagrafica&rowId=unset&openModal=unset&action=<?php echo cookie('rowId',false)?'update':'insert';?>" method="post">
                    <div class="mb-3" hidden="true">
                        <label for="modificaid" class="form-label">ID</label>
                        <input type="text" class="form-control" id="modificaid" name="id" value="<?php echo $edit['id']??'';?>">
                    </div>                
                    <div class="mb-3">
                        <label for="modalUtente" class="form-label">Utente</label>
                        <input type="text" class="form-control" id="modalUtente" name="utente" value="<?php echo $edit['utente']??'';?>">
                    </div>
                    <div class="mb-3">
                        <label for="modalEmail" class="form-label">Email</label>
                        <input type="text" class="form-control" id="modalEmail" name="email" value="<?php echo $edit['email']??'';?>">
                    </div>
                    <div class="mb-3">
                        <label for="modalPassword" class="form-label">Password</label>
                        <input type="text" class="form-control" id="modalPassword" name="password" value="<?php echo $edit['password']??'';?>">
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
<div class="modal fade" id="eliminaUtenteModal" tabindex="-1" aria-labelledby="eliminaUtenteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="eliminaUtenteModalLabel">Sicuro di voler eliminare ?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="utenti.php?tab=anagrafica&action=delete" method="post">
                    <div class="mb-3" hidden="true">
                        <label for="Elimina" class="form-label">ID</label>
                        <input type="text" class="form-control" id="EliminaId" name="id">
                    </div>
                    <div class="mb-3">
                        <label for="EliminaUtente" class="form-label">Utente</label>
                        <input type="text" class="form-control" id="EliminaUtente" name="utente" disabled>
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
<div class=" w-100 mx-1">
    <div class="card p">
        <?php $table=Utenti()->select_for_table(['limit'=>6,'orderby'=>'id DESC']);?>
        <div class="card-body d-flex flex-column">
            <div class="p-2 border my-1" style="border-bottom: 0px!important;border-radius: 10px 10px 0 0;">
                <table class="table table-striped border-0">
                    <thead>
                        <tr class="align-middle">
                            <th scope="col" class="text-center" rowspan="2">Utente</th>
                            <th scope="col" class="text-center" rowspan="2">Email</th>
                            <th scope="col" class="text-center" rowspan="2">Password</th>
                            <th scope="col" class="text-center" rowspan="2">#</th>
                        </tr>
                    </thead>
                    <tbody><?php
                        foreach ($table->result  as $row) {?>
                            <tr class="table-row" rowId="<?php echo $row['id'];?>">
                                <td scope="col" class="text-center"><?php echo $row['utente'];?></td>
                                <td scope="col" class="text-center"><?php echo $row['email'];?></td>
                                <td scope="col" class="text-center"><?php echo $row['password'];?></td>
                                <td scope="col" class="text-center action-Elimina" title="Elimina"><?php echo icon('bin.svg');?></td>
                            </tr><?php
                        }?>
                    </tbody>
                </table>
            </div>
            <script>
                const actions = {
                    btnInsert: document.querySelector('.modal-open'),
                    rowEdit: document.querySelectorAll('.table-row'),
                    delList: document.querySelectorAll('.action-Elimina'),
                    btnModal: document.querySelector('.btn-modal-cancel'),
                    iconDel: document.querySelectorAll('.action-Elimina'),
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
                        this.btnInsert.addEventListener('click', insertClick);
                        this.rowEdit.forEach(function(item){ item.addEventListener('click', editClick);});
                        this.delList.forEach(function(item){ item.addEventListener('click', delClick); });
                        this.iconDel.forEach(function(item){ item.addEventListener('mouseenter', hoverIconDel); });
                        this.btnModal.addEventListener('click',btnModalClick);
                    },
                };
                actions.listen();
                <?php if(cookie('openModal',false)) echo "openModal('utenteModal');"?>
            </script>            
        </div>
        <?php html()->pagination($table);?>
    </div>
</div>