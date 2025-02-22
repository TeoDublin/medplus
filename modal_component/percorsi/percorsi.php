<?php 
    function _view_percorsi(){
        return Select('*')
        ->from('view_percorsi')
        ->where("id_cliente={$_REQUEST['id_cliente']}")
        ->get_or_false();
    }
    function _view_sedute($id_percorso){
        return Select('*')
            ->from('view_sedute')
            ->where("id_percorso={$id_percorso}")
            ->get();
    }
    function _percorsi_terapeutici_sedute_prenotate($id_seduta){
        return Select('sp.id,sp.stato_prenotazione,DATE_FORMAT(sp.data,"%d/%m") as data,t.terapista,TIME_FORMAT(pri.ora,"%H:%i") as "ora_inizio", TIME_FORMAT(prf.ora,"%H:%i") as "ora_fine"')
            ->from('percorsi_terapeutici_sedute_prenotate','sp')
            ->left_join('terapisti t on sp.id_terapista = t.id')
            ->left_join('planning_row pri on sp.row_inizio = pri.id')
            ->left_join('planning_row prf on sp.row_fine = prf.id')
            ->where("sp.id_seduta={$id_seduta}")
            ->get();
    }
    function _nome_terapista($nome){
        $explode=explode(' ',$nome);
        $is_first=true;
        foreach(array_filter($explode) as $nome){
            if($is_first){
                $is_first=false;
                $span_class='';
            }
            else $span_class='d-none d-md-block';            
            echo "<span class=\"me-1 {$span_class}\">{$nome}</span>";
        }
    }
    style('modal_component/percorsi/percorsi.css');
    $_view_percorsi=_view_percorsi();
    $is_first=true;
?>
<div class="modal bg-dark bg-opacity-50" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Trattamenti In Corso</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="container"></div>
            <div class="modal-body">
                <div class="p-md-2">
                    <input type="text" id="id_cliente" value="<?php echo $_REQUEST['id_cliente']; ?>" hidden/>
                    <div class="container-fluid card text-center py-4">
                        <?php if(!$_view_percorsi){?>
                            <div class="card">
                                <div class="card-body">
                                    <span>Non ci sono trattamenti per questo cliente.</span>
                                </div>
                            </div><?php
                        }
                        else{ ?>
                            <div id="del-sedute" class="d-flex w-100 justify-content-end d-none">
                                <div class="d-flex flex-row w-100 gap-3">
                                    <button class="btn btn-warning w-100 d-flex flex-row align-items-center justify-content-center"
                                        onclick="window.modalHandlers['percorsi'].deleteSeduteClick(this,<?php echo $_REQUEST['id_cliente']; ?>);"
                                    ><?php echo icon('bin.svg',25,25); ?><span class="text-center">Elimina Sedute</span></button>
                                </div>
                            </div>                        
                            <div class="table-responsive">
                                <div class="my-0">
                                    <div class="flex-row titles w-100 d-flex">
                                        <div class="cc1 d-flex align-items-center justify-content-center text-center">
                                            <span class="#"></span>
                                        </div>
                                        <div class="cc2 d-flex align-items-center justify-content-center text-center">
                                            <span class="">Trattamento</span>
                                        </div>
                                        <div class="cc3 d-flex align-items-center justify-content-center text-center d-none d-md-block">
                                            <span class="">Inizio</span>
                                        </div>
                                        <div class="cc3 d-flex align-items-center justify-content-center text-center">
                                            <span class="d-none d-md-block">Prezzo</span>
                                            <span class="d-md-none">$</span>
                                        </div>
                                        <div class="cc3 d-flex align-items-center justify-content-center text-center">
                                            <span>N</span><span class="d-none d-md-block">ote</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php foreach ($_view_percorsi as $percorso) {
                                $view_sedute=_view_sedute($percorso['id']);
                                $show = false;
                                if($_REQUEST['id_percorso']){
                                    $show=$_REQUEST['id_percorso']==$percorso['id'];
                                }
                                else{
                                    $show = $is_first&&count($view_sedute)>0;
                                    $is_first = false;
                                }?>
                                <div class="accordion" id="accordion-percorso<?php echo $percorso['id'];?>">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <div class="accordion-button border py-2 <?php echo $show?'':'collapsed'; ?>" name="row_percorso" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-percorso<?php echo $percorso['id'];?>" aria-expanded="<?php echo $show; ?>" aria-controls="collapse-percorso<?php echo $percorso['id'];?>">
                                                <div class="d-flex flex-row w-100">
                                                    <input value="<?php echo $percorso['id'];?>" name="id_percorso" hidden/>
                                                    <div class="cc1 d-flex align-items-center justify-content-center text-center" 
                                                        onclick="window.modalHandlers['percorsi'].deleteClick(this)" 
                                                        onmouseenter="window.modalHandlers['percorsi'].deleteEnter(this)" 
                                                        onmouseleave="window.modalHandlers['percorsi'].deleteLeave(this)">
                                                        <?php echo icon('bin.svg','black',16,16); ?>
                                                    </div>
                                                    <div class="cc2 d-flex align-items-center justify-content-center text-center"
                                                            title=""
                                                            data-bs-toggle="popover"
                                                            data-bs-placement="right"
                                                            data-bs-title="Trattamenti"
                                                            data-bs-html="true"
                                                            data-bs-content="<?php echo str_replace(';', '<br>', htmlspecialchars($percorso['trattamento'], ENT_QUOTES, 'UTF-8')); ?>"
                                                            onmouseenter="window.modalHandlers['percorsi'].acronimoEnter(this)"
                                                            onmouseleave="window.modalHandlers['percorsi'].acronimoLeave(this)"
                                                        >
                                                        <span><?php echo $percorso['acronimo']; ?></span>
                                                    </div>
                                                    <div class="cc3 d-flex align-items-center justify-content-center text-center d-none d-md-block"><span class=""><?php echo format($percorso['timestamp'],'d/m/Y'); ?></span></div>
                                                    <div class="cc3 d-flex align-items-center justify-content-center text-center"><span class=""><?php echo $percorso['prezzo']; ?></span></div>
                                                    <div class="cc3 d-flex align-items-center justify-content-center text-center"
                                                            title=""
                                                            data-bs-toggle="popover"
                                                            data-bs-placement="right"
                                                            data-bs-title="Note"
                                                            data-bs-content="<?php echo $percorso['note']; ?>"
                                                            onmouseenter="window.modalHandlers['percorsi'].noteEnter(this)"
                                                            onmouseleave="window.modalHandlers['percorsi'].noteLeave(this)"
                                                        >
                                                        <?php echo icon('info.svg','black',20,20); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </h2>
                                        <div id="collapse-percorso<?php echo $percorso['id'];?>" class="accordion-collapse collapse <?php echo $show?'show':''; ?>" data-bs-parent="#accordion-percorso<?php echo $percorso['id'];?>">
                                            <div class="container-fluid card text-center py-4"><?php 
                                                if(empty($view_sedute)){?>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <span>Non ci sono sedute per questo percorso.</span>
                                                        </div>
                                                    </div><?php
                                                }
                                                else{ ?>
                                                    <div class="table-responsive">
                                                        <div class="my-0">
                                                            <div class="flex-row titles w-100 d-flex">
                                                                <div class="cs3 d-flex align-items-center justify-content-center text-center">
                                                                    <span>#</span>
                                                                </div>
                                                                <div class="cs1 d-flex align-items-center justify-content-center text-center">
                                                                    <span>Seduta</span>
                                                                </div>
                                                                <div class="cs2 d-flex align-items-center justify-content-center text-center">
                                                                    <span>Stato Seduta</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php foreach ($view_sedute as $seduta) {
                                                        $show_seduta=$_REQUEST['id_seduta']&&$seduta['id']==$_REQUEST['id_seduta'];
                                                        $sedute_prenotate=_percorsi_terapeutici_sedute_prenotate($seduta['id']);
                                                        $abble=in_array($seduta['stato'],['Da Prenotare','Assente','Spostata']);?>
                                                        <div class="accordion" id="accordionSeduta<?php echo $seduta['id'];?>">
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header">
                                                                    <div class="accordion-button  <?php echo $show_seduta?'':'collapsed'; ?> border py-2" type="button" data-bs-toggle="collapse"  name="row_percorso" data-bs-target="#collapseSeduta<?php echo $seduta['id'];?>" aria-expanded="<?php echo $show_seduta; ?>" aria-controls="collapseSeduta<?php echo $seduta['id'];?>">
                                                                        <input value="<?php echo $seduta['id'];?>" name="id_seduta" hidden/>
                                                                        <div class="d-flex flex-row w-100">
                                                                            <div class="cs3 d-flex align-items-center justify-content-center text-center">
                                                                                <?php 
                                                                                    if($abble){?>
                                                                                        <input type="checkbox" class="form-check w-100"
                                                                                            onclick="window.modalHandlers['percorsi'].check(this)"
                                                                                        ><?php
                                                                                    }
                                                                                    else{?>
                                                                                        <input type="checkbox" class="form-check w-100" disabled><?php
                                                                                    }
                                                                                ?>
                                                                                
                                                                            </div>
                                                                            <div class="cs1 d-flex align-items-center justify-content-center text-center"><span class=""><?php echo $seduta['index']; ?></span></div>
                                                                            <div class="cs2 d-flex align-items-center justify-content-center text-center">
                                                                                <?php if($abble){?>
                                                                                    <button class="btn btn-primary flex-fill" 
                                                                                    onclick="window.modalHandlers['percorsi'].prenotaSeduteClick(<?php echo $seduta['id'].','.$_REQUEST['id_cliente'].','.$percorso['id']; ?>)" 
                                                                                    onmouseenter="window.modalHandlers['percorsi'].prenotaEnter(this)" 
                                                                                    onmouseleave="window.modalHandlers['percorsi'].prenotaLeave(this)">PRENOTA</button><?php
                                                                                }
                                                                                else{?>
                                                                                    <button class="btn btn-dark flex-fill" disabled><?php echo strtoupper($seduta['stato']);?> </button><?php
                                                                                }?>
                                                                            </div>
                                                                        
                                                                        </div>
                                                                    </div>
                                                                </h2>
                                                                <div id="collapseSeduta<?php echo $seduta['id'];?>" class="accordion-collapse collapse <?php echo $show_seduta?'show':''; ?>" data-bs-parent="#accordionSeduta<?php echo $seduta['id'];?>">
                                                                    <?php if(empty($sedute_prenotate)){?>
                                                                        <div class="card">
                                                                            <div class="card-body">
                                                                                <span>Non ci sono sedute prenotate.</span>
                                                                            </div>
                                                                        </div><?php
                                                                    }
                                                                    else{ ?>
                                                                        <div class="table-responsive">
                                                                            <div class="my-0">
                                                                                <div class="flex-row seduta-titles w-100 d-flex">
                                                                                    <div class="csp1 d-flex align-items-center justify-content-center text-center">
                                                                                        <span class="">Terapista</span>
                                                                                    </div>
                                                                                    <div class="csp2 d-flex align-items-center justify-content-center text-center">
                                                                                        <span class="">Data</span>
                                                                                    </div>
                                                                                    <div class="csp2 d-flex align-items-center justify-content-center text-center">
                                                                                        <span class="">Inizio</span>
                                                                                    </div>
                                                                                    <div class="csp2 d-flex d-none d-md-block align-items-center justify-content-center text-center">
                                                                                        <span class="">Fine</span>
                                                                                    </div>
                                                                                    <div class="csp4 d-flex align-items-center justify-content-center text-center">
                                                                                        <span class="">Stato</span>
                                                                                    </div>
                                                                                    <div class="csp3 d-flex align-items-center justify-content-center text-center">
                                                                                        <span class="">#</span>
                                                                                    </div>
                                                                                </div>
                                                                                <?php foreach($sedute_prenotate as $seduta_prenotata){?>
                                                                                    <div class="flex-row seduta-titles w-100 d-flex ">
                                                                                        <div class="csp1 d-flex align-items-center justify-content-center text-center"><?php _nome_terapista($seduta_prenotata['terapista']); ?></div>
                                                                                        <div class="csp2 d-flex align-items-center justify-content-center text-center"><span class=""><?php echo $seduta_prenotata['data']; ?></span></div>
                                                                                        <div class="csp2 d-flex align-items-center justify-content-center text-center"><span class=""><?php echo $seduta_prenotata['ora_inizio']; ?></span></div>
                                                                                        <div class="csp2 d-flex d-none d-md-block align-items-center justify-content-center text-center"><span class=""><?php echo $seduta_prenotata['ora_fine']; ?></span></div>
                                                                                        <div class="csp4 d-flex align-items-center justify-content-center text-center statoHover">
                                                                                            <select type="text" class="form-control text-center" id="stato_prenotazione" value="<?php echo $seduta_prenotata['stato_prenotazione']??'';?>" 
                                                                                                onchange="window.modalHandlers['percorsi'].changeStatoPrenotazione(this,<?php echo $seduta_prenotata['id'].','.$seduta['id'];?>)">
                                                                                                <?php 
                                                                                                    foreach(Enum('percorsi_terapeutici_sedute_prenotate','stato_prenotazione')->list as $value){
                                                                                                        $selected = (isset($seduta_prenotata['stato_prenotazione']) && $seduta_prenotata['stato_prenotazione'] == $value) ? 'selected' : '';
                                                                                                        echo "<option value=\"{$value}\" class=\"ps-4  bg-white\" {$selected}>{$value}</option>";
                                                                                                    }
                                                                                                ?>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="csp3 d-flex align-items-center justify-content-center text-center delHover" 
                                                                                            onclick="window.modalHandlers['percorsi'].deleteSedutaPrenotata(this,<?php echo $seduta_prenotata['id'].','.$percorso['id'].','.$seduta['id']; ?>)" 
                                                                                            onmouseenter="window.modalHandlers['percorsi'].enterSedutaPrenotata(this);" 
                                                                                            onmouseleave="window.modalHandlers['percorsi'].leaveSedutaPrenotata(this);">
                                                                                            <?php echo icon('bin.svg','black',16,16); ?></div>
                                                                                    </div><?php                                        
                                                                                } ?>
                                                                            </div>
                                                                        </div><?php
                                                                    }?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <p class="psm"><?php
                                                    }?>
                                                    <div class="d-flex flex-row w-100 gap-3">
                                                        <button class="btn btn-dark w-100 d-flex flex-row align-items-center justify-content-center gap-3"
                                                            onclick="window.modalHandlers['percorsi'].addSeduteClick(<?php echo $_REQUEST['id_cliente'].','.$percorso['id'].','.$percorso['id_combo']; ?>);"
                                                        ><span class="text-center">Aggiungi Sedute</span></button>
                                                    </div> <?php                                                   
                                                }?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="psm"><?php
                            }
                        }?>
                        <div class="d-flex mt-2" 
                            onclick="window.modalHandlers['percorsi'].btnPercorsoClick(<?php echo $_REQUEST['id_cliente']; ?>)"
                        ><button class="btn btn-primary  flex-fill">Nuovo Trattamento</button></div>
                    </div>
                </div>
                <div class="p-md-2" id="prenota_planning"></div>
                <div class="p-md-2" id="percorso_combo"></div>
                <div class="p-md-2" id="sedute"></div>
                <div class="p-md-2" id="add_sedute"></div>
            </div>
        </div>
    </div>
</div>
<?php modal_script('percorsi'); ?>