<?php 
    style('modal_component/percorsi_fatture/percorsi_fatture.css');
    $session=Session();
    $ruolo=$session->get('ruolo')??false;

    function _origine($value){
        switch ($value['origine']) {
            case 'fatture':
                $ret = 'FATTURA';
                break;
            case 'isico':
                $ret = 'ISICO';
                break;
            case 'senza_fattura':
                $ret = 'SENZA FATTURA';
                break;
            case 'aruba':
                $ret = 'ARUBA';
                break;
        }

        return $ret;
    }

    // $ruolo!='display';
    $pagamenti = Select('*')->from('pagamenti')->where("id_cliente={$_REQUEST['id_cliente']}")->orderby('data desc')->get();
    $table = [];
    foreach ($pagamenti as $value) {
        $table[$value['data']][] = $value;
    }
?>
<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Pagamenti</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-span="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" id="id_cliente" value="<?php echo $_REQUEST['id_cliente']; ?>" hidden/>
                <div class="p-2">
                    <div class="container-fluid text-center py-4">
                        <?php if(empty($table)){?>
                            <div class="card">
                                <div class="card-body">
                                    <span>Non ci sono pagamenti per questo cliente.</span>
                                </div>
                            </div><?php
                        }
                        else{
                            foreach ($table as $data => $pagamento) {?>
                                <div class="d-flex w-100 ">
                                    <div class="d-flex w-100 ">
                                        <div class="accordion mb-2 w-100"  id="accordionFlush<?php echo $data;?>">
                                            <div class="accordion-item px-">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed border" type="button" data-bs-toggle="collapse" data-bs-target="#flush-<?php echo $data;?>" aria-expanded="false" aria-controls="flush-<?php echo $data;?>">
                                                        <div class="w-100">
                                                            <div class="h-100 text-center d-grid align-content-center justify-contents-center" style="padding:0!important">
                                                                <h5 class="p-0 m-0"><?php echo unformat_date($data); ?></h5>
                                                            </div>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="flush-<?php echo $data;?>" class="accordion-collapse collapse" data-bs-parent="#accordionFlush<?php echo $data;?>" >
                                                    <div class="accordion-body">
                                                        <!-- titles -->
                                                        <div class="d-flex mb-2" style="padding-left:20px;padding-right:40px;width:97%!important">
                                                            <div class="w-md-30">
                                                                <div class="d-grid h-100 align-content-center">
                                                                    Origine
                                                                </div>
                                                            </div>
                                                            <div class="w-15 d-none d-md-block">
                                                                <div class="d-grid h-100 align-content-center">
                                                                    Metodo
                                                                </div>                                    
                                                            </div>
                                                            <div class="w-15">
                                                                <div class="d-grid h-100 align-content-center">
                                                                    Stato
                                                                </div>
                                                            </div>
                                                            <div class="w-10 d-none d-md-block">
                                                                <div class="d-grid h-100 align-content-center">
                                                                    Imponibile
                                                                </div>
                                                            </div>
                                                            <div class="w-10 d-none d-md-block">
                                                                <div class="d-grid h-100 align-content-center">
                                                                    Inps
                                                                </div>
                                                            </div>
                                                            <div class="w-10">
                                                                <div class="d-grid h-100 align-content-center">
                                                                    Bollo
                                                                </div>
                                                            </div>
                                                            <div class="w-10">
                                                                <div class="d-grid h-100 align-content-center">
                                                                    Totale
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php 
                                                            foreach ($pagamento as $value) {
                                                                $origine = _origine($value);
                                                                $_origine = str_replace(' ','_',$origine);?>
                                                                <div class="w-100 d-flex flex-row accordion-row">
                                                                    <div class="accordion mb-2"  id="accordionFlush<?php echo $value['id'];?>" style="width:97%!important;">
                                                                        <div class="accordion-item px-0">
                                                                            <h2 class="accordion-header">
                                                                                <button class="accordion-button collapsed text-center <?php echo $_origine;?> border" type="button" data-bs-toggle="collapse" data-bs-target="#flush-<?php echo $value['id'];?>" aria-expanded="false" aria-controls="flush-<?php echo $value['id'];?>" style="width:100%!important;">
                                                                                    <div class="d-flex w-100">
                                                                                        <div class="w-md-30">
                                                                                            <div class="d-grid h-100 align-content-center">
                                                                                                <?php echo $origine;?>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="w-15 d-none d-md-block">
                                                                                            <div class="d-grid h-100 align-content-center">
                                                                                                <?php echo strtoupper($value['metodo']); ?>
                                                                                            </div>                                    
                                                                                        </div>
                                                                                        <div class="w-15">
                                                                                            <div class="d-grid h-100 align-content-center">
                                                                                                <?php 
                                                                                                    if($_origine=='FATTURA'&&$value['metodo']=='Bonifico'){
                                                                                                        echo "<select 
                                                                                                            data-id=\"".$value['id']."\"
                                                                                                            class=\"form-control text-center\" name=\"stato\" value=\"{$value['stato']}\" onchange=\"window.modalHandlers['percorsi_fatture'].statoChange(this);\">";
                                                                                                            foreach(Enum('fatture','stato')->get() as $enum){
                                                                                                                $selected=$value['stato']==$enum?'selected':'';
                                                                                                                echo "<option value=\"{$enum}\" {$selected}>{$enum}</option>";
                                                                                                            }
                                                                                                        echo "</select>";
                                                                                                    }
                                                                                                    else{
                                                                                                        echo strtoupper($value['stato']); 
                                                                                                    }
                                                                                                ?>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="w-10 d-none d-md-block">
                                                                                            <div class="d-grid h-100 align-content-center">
                                                                                                <?php echo number_format($value['imponibile'], 2, '.', ''); ?>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="w-10 d-none d-md-block">
                                                                                            <div class="d-grid h-100 align-content-center">
                                                                                                <?php echo number_format($value['inps'], 2, '.', ''); ?>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="w-10">
                                                                                            <div class="d-grid h-100 align-content-center">
                                                                                                <?php echo number_format($value['bollo'], 2, '.', ''); ?>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="w-10">
                                                                                            <div class="d-grid h-100 align-content-center">
                                                                                                <?php echo $value['totale']; ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </button>
                                                                            </h2>
                                                                            <div id="flush-<?php echo $value['id'];?>" class="accordion-collapse collapse" data-bs-parent="#accordionFlush<?php echo $value['id'];?>">
                                                                                <div class="accordion-body">

                                                                                    <div class="d-flex flex-column w-100 ">
                                                                                        <?php 
                                                                                            if($value['origine']=='fatture'){
                                                                                                $fattura = Select('*')->from('fatture')->where("id_pagamenti={$value['id']}")->first();
                                                                                                echo "<div class=\"w-100 d-flex flex-row border bg-primary rounded mb-4\">
                                                                                                    <a class=\"w-100 text-decoration-none text-black p-1 text-white\" id=\"link\" href=\"".fatture_url($fattura['link'])."\" target=\"_blank\">
                                                                                                        ". icon('pdf.svg','white',20,20)."
                                                                                                        <span> {$fattura['index']}.pdf</span>
                                                                                                    </a>
                                                                                                </div>";
                                                                                            }?>
                                                                                            <!-- titles -->
                                                                                            <div class="d-flex w-100 my-3" style="padding-left:20px;padding-right:40px">
                                                                                                <div class="w-10">
                                                                                                    <div class="d-grid h-100 align-content-center">
                                                                                                        Origine
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="w-md-30">
                                                                                                    <div class="d-grid h-100 align-content-center">
                                                                                                        trattamento/Corso
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="w-15">
                                                                                                    <div class="d-grid h-100 align-content-center">
                                                                                                        Seduta/Scadenza
                                                                                                    </div>                                    
                                                                                                </div>
                                                                                                <div class="w-15">
                                                                                                    <div class="d-grid h-100 align-content-center">
                                                                                                        Prezzo
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="w-15 d-none d-md-block">
                                                                                                    <div class="d-grid h-100 align-content-center">
                                                                                                        Terapista
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="w-15 d-none d-md-block">
                                                                                                    <div class="d-grid h-100 align-content-center">
                                                                                                        Realizzato da
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <?php 
                                                                                                $binds = Select('*')->from('view_pagamenti_child')->where("id_pagamenti={$value['id']}")->get();
                                                                                                foreach ($binds as $bind) {
                                                                                                    switch ($bind['origine']) {
                                                                                                        case 'trattamenti':{?>
                                                                                                            <div class="d-flex w-100 border py-3" style="padding-left:20px;padding-right:40px">
                                                                                                                <div class="w-10">
                                                                                                                    <div class="d-grid h-100 align-content-center">
                                                                                                                        Trattamento
                                                                                                                    </div>                                    
                                                                                                                </div>
                                                                                                                <div class="w-md-30">
                                                                                                                    <div class="d-grid h-100 align-content-center">
                                                                                                                        <?php echo $bind['trattamenti']; ?>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="w-15">
                                                                                                                    <div class="d-grid h-100 align-content-center">
                                                                                                                        <?php echo empty($bind['data_seduta']) ? 'Da Prenotare' : unformat_date($bind['data_seduta']); ?>
                                                                                                                    </div>                                    
                                                                                                                </div>
                                                                                                                <div class="w-15">
                                                                                                                    <div class="d-grid h-100 align-content-center">
                                                                                                                        <?php echo $bind['prezzo']; ?>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="w-15 d-none d-md-block">
                                                                                                                    <div class="d-grid h-100 align-content-center">
                                                                                                                        <?php echo $bind['terapista']; ?>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="w-15 d-none d-md-block">
                                                                                                                    <div class="d-grid h-100 align-content-center">
                                                                                                                        <?php echo $bind['realizzato_da']; ?>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div><?php
                                                                                                            break;
                                                                                                        }
                                                                                                        case 'corsi':{?>
                                                                                                            <div class="d-flex w-100  border py-3" style="padding-left:20px;padding-right:40px">
                                                                                                                <div class="w-10">
                                                                                                                    <div class="d-grid h-100 align-content-center">
                                                                                                                        Corso
                                                                                                                    </div>                                    
                                                                                                                </div>
                                                                                                                <div class="w-md-30">
                                                                                                                    <div class="d-grid h-100 align-content-center">
                                                                                                                        <?php echo $bind['corso']; ?>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="w-15">
                                                                                                                    <div class="d-grid h-100 align-content-center">
                                                                                                                        <?php echo unformat_date($bind['corso_scadenza']); ?>
                                                                                                                    </div>                                    
                                                                                                                </div>
                                                                                                                <div class="w-15">
                                                                                                                    <div class="d-grid h-100 align-content-center">
                                                                                                                        <?php echo $bind['corso_prezzo']; ?>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="w-15 d-none d-md-block">
                                                                                                                    <div class="d-grid h-100 align-content-center">
                                                                                                                        <?php echo $bind['corso_terapista']; ?>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="w-15 d-none d-md-block">
                                                                                                                    <div class="d-grid h-100 align-content-center">
                                                                                                                        <?php echo $bind['corso_realizzato_da']; ?>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div><?php
                                                                                                            break;
                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                            ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-2 del d-flex justify-content-center align-items-center" style="width:3%!important;"
                                                                        data-table="<?php echo $value['origine'];?>"
                                                                        data-id="<?php echo $value['id'];?>"
                                                                        data-id_cliente="<?php echo $value['id_cliente'];?>"
                                                                        onmouseenter="window.modalHandlers['percorsi_fatture'].delEnter(this);"
                                                                        onmouseleave="window.modalHandlers['percorsi_fatture'].delLeave(this);"
                                                                        onclick="window.modalHandlers['percorsi_fatture'].delClick(this);">
                                                                        <?php echo icon('bin.svg','red',20,20); ?>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php 
        module_script('fattura');
        modal_script('percorsi_fatture'); 
    ?>
</div>