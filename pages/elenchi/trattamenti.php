<div class="d-flex flex-row w-100 p-2">
    <button type="button" class="btn btn-primary p-2 d-flex flex-row" data-bs-toggle="modal" data-bs-target="#aggiungiTrattamentoModal">
        <div class="mx-2"><?php echo icon('cloud-add.svg','white',20,20);?></div>
        <div>Aggiungi Trattamento</div>
    </button>                            
</div>
<div class="modal fade" id="aggiungiTrattamentoModal" tabindex="-1" aria-labelledby="aggiungiTrattamentoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="aggiungiTrattamentoModalLabel">Aggiungi Trattamento</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="elenchi.php?tab=trattamenti" method="post">
                    <div class="mb-3">
                        <label for="trattamento" class="form-label">Trattamento</label>
                        <input type="text" class="form-control" id="trattamento" name="trattamento">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                        <button type="submit" name="submit" class="btn btn-primary">Aggiungi</button>
                    </div>                                        
                </form>
            </div>
        </div>
    </div>
</div>
<?php html()->table(['Trattamento'],Trattamenti()->select_for_table(['select'=>['id','trattamento'],'limit'=>6,'orderby'=>'id DESC']),['del'=>'Elimina','edit'=>'Modifica']);?>