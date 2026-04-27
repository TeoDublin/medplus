<?php

    function _select($tipo_percorso, $tipo_percentuale, $terapisti){

        return Select('*')
            ->from('terapisti_percentuali')
            ->where("tipo_percorso = '{$tipo_percorso}' AND tipo_percentuale = '{$tipo_percentuale}' AND id_terapista = {$terapisti['id']}" )
            ->col('percentuale') ?? 0 ;
    }

    $id = (int) $_REQUEST['id'];

    $terapisti = !null_or_empty($id) ? Select('*')->from('terapisti')->where("id={$id}")->first_or_false() : false;

    $terapista = $terapisti ? $terapisti['terapista'] : '';
    $profilo = $terapisti ? $terapisti['profilo'] : 'Terapista';

    $trattamenti_medplus = $terapisti ? _select('Trattamenti', 'Medplus', $terapisti) : 0;
    $trattamenti_isico_salerno = $terapisti ? _select('Trattamenti', 'Isico Salerno', $terapisti) : 0;
    $trattamenti_isico_napoli = $terapisti ? _select('Trattamenti', 'Isico Napoli', $terapisti) : 0;
    $trattamenti_dz = $terapisti ? _select('Trattamenti', 'Daniela Zanotti', $terapisti) : 0;

    $corsi_medplus = $terapisti ? _select('Corsi', 'Medplus', $terapisti) : 0;
    $corsi_isico_salerno = $terapisti ? _select('Corsi', 'Isico Salerno', $terapisti) : 0;
    $corsi_isico_napoli = $terapisti ? _select('Corsi', 'Isico Napoli', $terapisti) : 0; 
    $corsi_dz = $terapisti ? _select('Corsi', 'Daniela Zanotti', $terapisti) : 0; 

?>

<div class="modal bg-dark bg-opacity-50 vh-100" id="<?= $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" data-id="<?= $id; ?>">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div class="modal-header"><h4 class="modal-title">Aggiungi Terapista</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?= $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>

            <div class="modal-body text-center">

                <div class="d-flex flex-row">

                    <div class="p-1 card d-flex w-100">

                        <div class="card-body p-1 d-flex">

                            <div class="p-1 flex-fill">
                                <label for="terapista" class="form-label fw-bold">Terapista</label>
                                <input type="text" name="terapista" id="terapista" class="form-control text-center" value="<?= $terapista; ?>"/>
                            </div>

                            <div class="p-1 w-20">
                                <label for="data" class="form-label fw-bold" >Profilo</label><?php
                                echo "<select class=\"form-control text-center\" name=\"profilo\" id=\"profilo\" value=\"{$profilo}\">";
                                    foreach(Enum('terapisti','profilo')->get() as $enum){
                                        $selected = $enum == $profilo ? 'selected' : '';
                                        echo "<option value=\"{$enum}\" {$selected}>{$enum}</option>";
                                    }
                                echo "</select>";?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-row mt-2">

                    <div class="p-1 card d-flex w-100">

                        <h6 class="card-title mt-1">Percentuali</h6>

                        <div class="card-body p-1 d-flex">

                            <div class="p-1 card flex-fill">

                                <h6 class="card-title mt-1">Trattamenti</h6>

                                <div class="card-body p-1">
                                    
                                    <table class="table border-light border-radius-1">
                                        <tr class="border-light">
                                            <td class="border-light">Medplus</td>
                                            <td class="border-light">
                                                <input type="number" id="trattamenti_medplus" class="form-control text-center" value="<?= $trattamenti_medplus;?>"/>
                                            </td>
                                        </tr>
                                        <tr class="border-light">
                                            <td class="border-light">Isico Salerno</td>
                                            <td class="border-light">
                                                <input type="number" id="trattamenti_isico_salerno" class="form-control text-center" value="<?= $trattamenti_isico_salerno;?>"/>
                                            </td>
                                        </tr>
                                        <tr class="border-light">
                                            <td class="border-light">Isico Napoli</td>
                                            <td class="border-light">
                                                <input type="number" id="trattamenti_isico_napoli" class="form-control text-center" value="<?= $trattamenti_isico_napoli;?>"/>
                                            </td>
                                        </tr>
                                        <tr class="border-light">
                                            <td class="border-light">Daniela Zanotti</td>
                                            <td class="border-light">
                                                <input type="number" id="trattamenti_dz" class="form-control text-center" value="<?= $trattamenti_dz;?>"/>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="p-1 card ms-2 w-50">

                                <h6 class="card-title mt-1">Corsi</h6>

                                <div class="card-body p-1">
                                    
                                    <table class="table border-light border-radius-1">
                                        <tr class="border-light">
                                            <td class="border-light">Medplus</td>
                                            <td class="border-light">
                                                <input type="number" id="corsi_medplus" class="form-control text-center" value="<?= $corsi_medplus;?>"/>
                                            </td>
                                        </tr>
                                        <tr class="border-light">
                                            <td class="border-light">Isico Salerno</td>
                                            <td class="border-light">
                                                <input type="number" id="corsi_isico_salerno" class="form-control text-center" value="<?= $corsi_isico_salerno;?>"/>
                                            </td>
                                        </tr>
                                        <tr class="border-light">
                                            <td class="border-light">Isico Napoli</td>
                                            <td class="border-light">
                                                <input type="number" id="corsi_isico_napoli" class="form-control text-center" value="<?= $corsi_isico_napoli;?>"/>
                                            </td>
                                        </tr>
                                        <tr class="border-light">
                                            <td class="border-light">Daniela Zanotti</td>
                                            <td class="border-light">
                                                <input type="number" id="corsi_dz" class="form-control text-center" value="<?= $corsi_dz;?>"/>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['terapisti_percentuali'].btnSalva(this)">Salva</a>
            </div>
        </div>
    </div>
</div>
<?php modal_script('terapisti_percentuali'); ?>