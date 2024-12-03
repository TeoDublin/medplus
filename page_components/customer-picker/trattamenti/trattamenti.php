<?php 
    function _percorso(){
        return Select('c.id,c.percorso,c.sedute_totale,c.sedute_da_pianificare,c.stato_sedute')
        ->from('percorsi','c')
        ->where("id_cliente={$_REQUEST['id_cliente']}")
        ->get_or_false();
    }
    function _sedute($id_percorso){
        return Select('s.id,s.index,s.id_trattamento,s.stato_seduta,t.trattamento')
            ->from('sedute','s')
            ->left_join('trattamenti t on s.id_trattamento = t.id')
            ->where("s.id_percorso={$id_percorso}")
            ->get();
    }
    function _sedute_prenotate($id_seduta){
        return Select('sp.id,sp.id_terapista,sp.data,sp.ora,sp.stato_prenotazione,t.terapista')
            ->from('sedute_prenotate','sp')
            ->left_join('terapisti t on sp.id_terapista = t.id')
            ->where("sp.id_seduta={$id_seduta}")
            ->get();
    }
    style('page_components/customer-picker/trattamenti/trattamenti.css');
    $_percorso=_percorso();
?>
<div class="p-2" id="customer-picker_trattamenti">
    <input type="text" id="id_cliente" value="<?php echo $_REQUEST['id_cliente']; ?>" hidden/>
    <div class="container-fluid card text-center py-4">
        <h4 class="mb-3">Prenotazioni</h4>
        <?php if(!$_percorso){?>
            <div class="card">
                <div class="card-body">
                    <label>Non ci sono prenotazioni per questo cliente.</label>
                </div>
            </div><?php
        }
        else{ ?>
            <div class="table-responsive">
                <div class="my-0">
                    <div class="flex-row titles w-100 d-flex">
                        <div class="cc1 d-flex align-items-center justify-content-center text-center">
                            <label class="form-label"></label>
                        </div>
                        <div class="cc2 d-flex align-items-center justify-content-center text-center">
                            <label class="form-label"></label>
                        </div>
                        <div class="cc3 d-flex align-items-center justify-content-center text-center">
                            <label class="form-label">Percorso Terapeutico</label>
                        </div>
                        <div class="cc4 d-flex align-items-center justify-content-center text-center">
                            <label class="form-label">Totale</label>
                        </div>
                        <div class="cc5 d-flex align-items-center justify-content-center text-center">
                            <label class="form-label">Da Pianificare</label>
                        </div>
                        <div class="cc6 d-flex align-items-center justify-content-center text-center">
                            <label class="form-label">Stato Sedute</label>
                        </div>
                    </div>
                </div>
            </div>
            <?php foreach ($_percorso as $percorso) {?>
                <div class="accordion" id="accordion-percorso<?php echo $percorso['id'];?>">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <div class="accordion-button collapsed border py-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-percorso<?php echo $percorso['id'];?>" aria-expanded="false" aria-controls="collapse-percorso<?php echo $percorso['id'];?>">
                                <div class="d-flex flex-row w-100">
                                    <div class="cc1 d-flex align-items-center justify-content-center text-center"><?php echo icon('edit.svg','black',16,16); ?></div>
                                    <div class="cc2 d-flex align-items-center justify-content-center text-center"><?php echo icon('bin.svg','black',16,16); ?></div>
                                    <div class="cc3 d-flex align-items-center justify-content-center text-center"><label class="form-label"><?php echo $percorso['percorso']; ?></label></div>
                                    <div class="cc4 d-flex align-items-center justify-content-center text-center"><label class="form-label"><?php echo $percorso['sedute_totale']; ?></label></div>
                                    <div class="cc5 d-flex align-items-center justify-content-center text-center"><label class="form-label"><?php echo $percorso['sedute_da_pianificare']; ?></label></div>
                                    <div class="cc6 d-flex align-items-center justify-content-center text-center"><label class="form-label"><?php echo $percorso['stato_sedute']; ?></label></div>
                                </div>
                            </div>
                        </h2>
                        <div id="collapse-percorso<?php echo $percorso['id'];?>" class="accordion-collapse collapse" data-bs-parent="#accordion-percorso<?php echo $percorso['id'];?>">
                            <div class="container-fluid card text-center py-4">
                                <div class="table-responsive">
                                    <div class="my-0">
                                        <div class="flex-row titles w-100 d-flex">
                                            <div class="cs1 d-flex align-items-center justify-content-center text-center">
                                                <label class="form-label"></label>
                                            </div>
                                            <div class="cs2 d-flex align-items-center justify-content-center text-center">
                                                <label class="form-label"></label>
                                            </div>
                                            <div class="cs3 d-flex align-items-center justify-content-center text-center">
                                                <label class="form-label">Seduta</label>
                                            </div>
                                            <div class="cs4 d-flex align-items-center justify-content-center text-center">
                                                <label class="form-label">Trattamento</label>
                                            </div>
                                            <div class="cs5 d-flex align-items-center justify-content-center text-center">
                                                <label class="form-label">Stato Seduta</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php foreach (_sedute($percorso['id']) as $seduta) {?>
                                    <div class="accordion" id="accordionSeduta<?php echo $seduta['id'];?>">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <div class="accordion-button collapsed border py-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeduta<?php echo $seduta['id'];?>" aria-expanded="false" aria-controls="collapseSeduta<?php echo $seduta['id'];?>">
                                                    <div class="d-flex flex-row w-100">
                                                        <div class="cs1 d-flex align-items-center justify-content-center text-center"><?php echo icon('edit.svg','black',16,16); ?></div>
                                                        <div class="cs2 d-flex align-items-center justify-content-center text-center"><?php echo icon('bin.svg','black',16,16); ?></div>
                                                        <div class="cs3 d-flex align-items-center justify-content-center text-center"><label class="form-label"><?php echo $seduta['index']; ?></label></div>
                                                        <div class="cs4 d-flex align-items-center justify-content-center text-center"><label class="form-label"><?php echo $seduta['trattamento']; ?></label></div>
                                                        <div class="cs5 d-flex align-items-center justify-content-center text-center"><label class="form-label"><?php echo $seduta['stato_seduta']; ?></label></div>
                                                    </div>
                                                </div>
                                            </h2>
                                            <div id="collapseSeduta<?php echo $seduta['id'];?>" class="accordion-collapse collapse" data-bs-parent="#accordionSeduta<?php echo $seduta['id'];?>">
                                                <div class="table-responsive">
                                                    <div class="my-0">
                                                        <div class="flex-row titles w-100 d-flex">
                                                            <div class="csp1 d-flex align-items-center justify-content-center text-center">
                                                                <label class="form-label">Terapista</label>
                                                            </div>
                                                            <div class="csp2 d-flex align-items-center justify-content-center text-center">
                                                                <label class="form-label">Data</label>
                                                            </div>
                                                            <div class="csp3 d-flex align-items-center justify-content-center text-center">
                                                                <label class="form-label">Ora</label>
                                                            </div>
                                                            <div class="csp4 d-flex align-items-center justify-content-center text-center">
                                                                <label class="form-label">Stato Prenotazione</label>
                                                            </div>
                                                            <div class="csp5 d-flex align-items-center justify-content-center text-center">
                                                                <label class="form-label">Elimina</label>
                                                            </div>
                                                        </div>
                                                        <?php foreach(_sedute_prenotate($seduta['id']) as $seduta_prenotata){?>
                                                            <div class="flex-row titles w-100 d-flex">
                                                                <div class="csp1 d-flex align-items-center justify-content-center text-center"><label class="form-label"><?php echo $seduta_prenotata['terapista']; ?></label></div>
                                                                <div class="csp2 d-flex align-items-center justify-content-center text-center"><label class="form-label"><?php echo $seduta_prenotata['data']; ?></label></div>
                                                                <div class="csp3 d-flex align-items-center justify-content-center text-center"><label class="form-label"><?php echo $seduta_prenotata['ora']; ?></label></div>
                                                                <div class="csp4 d-flex align-items-center justify-content-center text-center"><label class="form-label"><?php echo $seduta_prenotata['stato_prenotazione']; ?></label></div>
                                                                <div class="csp5 d-flex align-items-center justify-content-center text-center"><?php echo icon('bin.svg','black',16,16); ?></div>
                                                            </div><?php                                        
                                                        } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="psm"><?php
                                }?>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="psm"><?php
            }
        }?>
        <div class="d-flex mt-2" onclick="btnClick()"><button class="btn btn-primary  flex-fill">Nuovo Percorso Terapeutico</button></div>
    </div>
</div>
<?php script('page_components/customer-picker/trattamenti/trattamenti.js'); ?>