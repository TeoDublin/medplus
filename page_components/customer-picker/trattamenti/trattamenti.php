<?php 
    function _ciclo(){
        return Select('*cicli*,*trattamenti*')
        ->from('cicli','c')
        ->left_join('trattamenti t on c.id_trattamento = t.id')
        ->where('id_cliente=40')
        ->get();
    }
?>
<div class="p-2">
    <input type="text" name="tab" value="trattamenti" hidden/>
    <div class="accordion" id="accordionExample">
        <div class="container-fluid">
            <div class="table-responsive">
                <div class="row w-100">
                    <div class="col-4 d-flex align-items-center justify-content-center text-center">
                        <label class="form-label">trattamento</label>
                    </div>
                    <div class="col-3 d-flex align-items-center justify-content-center text-center">
                        <label class="form-label">stato sedute</label>
                    </div>
                    <div class="col-3 d-flex align-items-center justify-content-center text-center">
                        <label class="form-label">stato pagamenti</label>
                    </div>
                    <div class="col-1 d-flex align-items-center justify-content-center text-center">
                        <label class="form-label">sedute totale</label>
                    </div>
                    <div class="col-1 d-flex align-items-center justify-content-center text-center">
                        <label class="form-label">da pianificare</label>
                    </div>
                </div>
            </div>
        </div>


        <?php 
            foreach (_ciclo() as $ciclo) {?>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <div class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            <div class="d-flex flex-row w-100">
                                <div class="col-4 text-center"><label class="form-label"><?php echo $ciclo['trattamento']; ?></label></div>
                                <div class="col-3 text-center"><label class="form-label"><?php echo $ciclo['stato_sedute']; ?></label></div>
                                <div class="col-3 text-center"><label class="form-label"><?php echo $ciclo['stato_pagamenti']; ?></label></div>
                                <div class="col-1 text-center"><label class="form-label"><?php echo $ciclo['sedute_totale']; ?></label></div>
                                <div class="col-1 text-center"><label class="form-label"><?php echo $ciclo['sedute_da_pianificare']; ?></label></div>
                            </div>
                        </div>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                        <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div><?php
            }
        ?>
    </div>
</div>