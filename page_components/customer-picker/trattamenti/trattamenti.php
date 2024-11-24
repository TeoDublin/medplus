<?php 
    function _ciclo(){
        return Select('*cicli*,*trattamenti*,c.id')
        ->from('cicli','c')
        ->left_join('trattamenti t on c.id_trattamento = t.id')
        ->where('id_cliente=40')
        ->get();
    }
    function _sedute($id_ciclo){
        return Select('*cicli*,*sedute*,*trattamento*,*cliente*,*terapista*')
            ->from('sedute','s')
            ->left_join('cicli c on s.id_ciclo = c.id')
            ->left_join('trattamento t on s.id_trattamento = t.id')
            ->left_join('cliente cl on s.id_cliente = cl.id')
            ->left_join('terapista t on s.id_terapista = t.id')
            ->where("s.id_ciclo={$id_ciclo}")
            ->get();
    }
    style('page_components/customer-picker/trattamenti/trattamenti.css');
?>
<div class="p-2">
    <input type="text" name="tab" value="trattamenti" hidden/>
    
        <div class="container-fluid card text-center py-4">
            <h4 for="card-title">Trattamenti Prenotati</h4>
            <div class="table-responsive">
                <div class="my-0">
                    <div class="flex-row titles w-100 d-flex">
                        <div class="c-1 d-flex align-items-center justify-content-center text-center">
                            <label class="form-label">#</label>
                        </div>
                        <div class="c-2 d-flex align-items-center justify-content-center text-center">
                            <label class="form-label">#</label>
                        </div>
                        <div class="c-3 d-flex align-items-center justify-content-center text-center">
                            <label class="form-label">trattamento</label>
                        </div>
                        <div class="c-4 d-flex align-items-center justify-content-center text-center">
                            <label class="form-label">stato sedute</label>
                        </div>
                        <div class="c-5 d-flex align-items-center justify-content-center text-center">
                            <label class="form-label">stato pagamenti</label>
                        </div>
                        <div class="c-6 d-flex align-items-center justify-content-center text-center">
                            <label class="form-label">sedute totale</label>
                        </div>
                        <div class="c-7 d-flex align-items-center justify-content-center text-center">
                            <label class="form-label">da pianificare</label>
                        </div>
                    </div>
                </div>

            </div>
            <?php 
                foreach (_ciclo() as $ciclo) {?>
                    <div class="accordion" id="accordion<?php echo $ciclo['id'];?>">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <div class="accordion-button collapsed border py-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $ciclo['id'];?>" aria-expanded="false" aria-controls="collapse<?php echo $ciclo['id'];?>">
                                    <div class="d-flex flex-row w-100">
                                        <div class="c-1 d-flex align-items-center justify-content-center text-center"><?php echo icon('edit.svg','black',16,16); ?></div>
                                        <div class="c-2 d-flex align-items-center justify-content-center text-center"><?php echo icon('bin.svg','black',16,16); ?></div>
                                        <div class="c-3 d-flex align-items-center justify-content-center text-center"><label class="form-label"><?php echo $ciclo['trattamento']; ?></label></div>
                                        <div class="c-4 d-flex align-items-center justify-content-center text-center"><label class="form-label"><?php echo $ciclo['stato_sedute']; ?></label></div>
                                        <div class="c-5 d-flex align-items-center justify-content-center text-center"><label class="form-label"><?php echo $ciclo['stato_pagamenti']; ?></label></div>
                                        <div class="c-6 d-flex align-items-center justify-content-center text-center"><label class="form-label"><?php echo $ciclo['sedute_totale']; ?></label></div>
                                        <div class="c-7 d-flex align-items-center justify-content-center text-center"><label class="form-label"><?php echo $ciclo['sedute_da_pianificare']; ?></label></div>
                                    </div>
                                </div>
                            </h2>
                            <div id="collapse<?php echo $ciclo['id'];?>" class="accordion-collapse collapse" data-bs-parent="#accordion<?php echo $ciclo['id'];?>">
                                <div class="accordion-body">
                                    <?php 
                                        foreach (_sedute($ciclo['id']) as $seduta) {?>
                                            <div class="accordion" id="accordionSeduta<?php echo $seduta['id'];?>">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <div class="accordion-button collapsed border py-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $ciclo['id'];?>" aria-expanded="false" aria-controls="collapse<?php echo $ciclo['id'];?>">
                                                            <div class="d-flex flex-row w-100">
                                                                <div class="c-1 d-flex align-items-center justify-content-center text-center"><?php echo icon('edit.svg','black',16,16); ?></div>
                                                                <div class="c-2 d-flex align-items-center justify-content-center text-center"><?php echo icon('bin.svg','black',16,16); ?></div>
                                                                <div class="c-3 d-flex align-items-center justify-content-center text-center"><label class="form-label"><?php echo $ciclo['trattamento']; ?></label></div>
                                                                <div class="c-4 d-flex align-items-center justify-content-center text-center"><label class="form-label"><?php echo $ciclo['stato_sedute']; ?></label></div>
                                                                <div class="c-5 d-flex align-items-center justify-content-center text-center"><label class="form-label"><?php echo $ciclo['stato_pagamenti']; ?></label></div>
                                                                <div class="c-6 d-flex align-items-center justify-content-center text-center"><label class="form-label"><?php echo $ciclo['sedute_totale']; ?></label></div>
                                                                <div class="c-7 d-flex align-items-center justify-content-center text-center"><label class="form-label"><?php echo $ciclo['sedute_da_pianificare']; ?></label></div>
                                                            </div>
                                                        </div>
                                                    </h2>
                                                    <div id="collapse<?php echo $ciclo['id'];?>" class="accordion-collapse collapse" data-bs-parent="#accordion<?php echo $ciclo['id'];?>">
                                                        <div class="accordion-body">
                                                        <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="psm"><?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="psm"><?php
                }
            ?>
        </div>
    </div>
</div>