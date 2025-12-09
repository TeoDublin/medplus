<?php 
    require_once '../../includes.php';
    $session=Session();
    $ruolo=$session->get('ruolo')??false;

    function _has_filters(){
        return count($_POST)>0&&!isset($_REQUEST['btnClean']);
    }

    if($ruolo=='display'){
        $where = "( tipo_pagamento IS NULL OR tipo_pagamento <> 'Senza Fattura' ) AND bnw <> 'no'";
    }
    else{
        $where = '1=1';
    }
    
    $url='pagamenti.php';
    if(_has_filters()){

        if(!isset($_POST['data_seduta']['all'])){
            if(isset($_POST['data_seduta']['da'])){
                $where.=" AND data_seduta >='{$_POST['data_seduta']['da']}'";
            }
            if(isset($_POST['data_seduta']['a'])){
                $where.=" AND data_seduta <='{$_POST['data_seduta']['a']}'";
            }    
        }

        if(!isset($_POST['data_pagamento']['all'])){
            if(isset($_POST['data_pagamento']['da'])){
                $where.=" AND data_pagamento >='{$_POST['data_pagamento']['da']}'";
            }
            if(isset($_POST['data_pagamento']['a'])){
                $where.=" AND data_pagamento <='{$_POST['data_pagamento']['a']}'";
            }    
        }

        if(isset($_POST['id_terapista'])){
            $where.=" AND id_terapista IN(".implode(',',$_POST['id_terapista']).")";
        }

        if(isset($_POST['stato_seduta'])){
            $where.=" AND stato_seduta IN('".implode("','",$_POST['stato_seduta'])."')";
        }

        if(isset($_POST['stato_pagamento'])){
            $where.=" AND stato_pagamento IN('".implode("','",$_POST['stato_pagamento'])."')";
        }

        if(isset($_POST['metodo'])){
            $where.=" AND metodo IN('".implode("','",$_POST['metodo'])."')";
        }

        if(isset($_POST['tipo_pagamento'])){
            $where.=" AND tipo_pagamento IN('".implode("','",$_POST['tipo_pagamento'])."')";
        }

        if(isset($_POST['realizzato_da'])){
            $where.=" AND realizzato_da IN('".implode("','",$_POST['realizzato_da'])."')";
        }

        if(isset($_POST['bnw'])){
            $where.=" AND bnw IN('".implode("','",$_POST['bnw'])."')";
        }

        if(isset($_POST['stato_saldato_terapista'])){
            $where.=" AND stato_saldato_terapista IN('".implode("','",$_POST['stato_saldato_terapista'])."')";
        }

        if(isset($_POST['cliente'])){
            $where.=" AND id_cliente IN(".implode(',',$_POST['cliente']).")";
        }

    }
    elseif(!isset($_REQUEST['btnClean'])){
        $_POST['stato_pagamento']=['Saldato'];
        $_POST['data_pagamento']['da']=date('Y-m-d');
        $_POST['data_pagamento']['a']=date('Y-m-d');
        $where.=" AND data_pagamento >='{$_POST['data_pagamento']['da']}' AND data_pagamento <='{$_POST['data_pagamento']['a']}'";
        $where.=" AND stato_pagamento IN('".implode("','",$_POST['stato_pagamento'])."')";
    }

    $view_sedute = Select('*')->from('view_sedute')->where($where)->orderby('data_seduta ASC')->get_table();
    $sum= Select("sum(prezzo) as prezzo, sum(saldato) as saldato")->from('view_sedute')->where($where)->first();
?>

<!-- where -->
<div class="filter-labels d-flex flex-row align-items-center bg-light p-2">
    <span class="fw-bold">FILTRI APPLICATI:</span>
    <?php
    if(_has_filters()){?>
        <?php

            if(!isset($_POST['data_seduta']['all'])){
                if(isset($_POST['data_seduta']['da'])){
                    echo "<div class=\"filter-label bg-gray\"><span >Seduta Da: ".unformat_date($_POST['data_seduta']['da'])."</span></div>"; 
                }
                if(isset($_POST['data_seduta']['a'])){
                    echo "<div class=\"filter-label bg-gray\"><span >Seduta A: ".unformat_date($_POST['data_seduta']['a'])."</span></div>";    
                }                
            }

            if(isset($_POST['id_terapista'])){
                echo "<div class=\"filter-label bg-gray\"><span >Terapista: ".implode(', ',$_POST['terapista'])."</span></div>";
            }

            if(isset($_POST['stato_seduta'])){
                echo "<div class=\"filter-label bg-gray\"><span >Stato Seduta: ".implode(', ',$_POST['stato_seduta'])."</span></div>";
            }

            if(isset($_POST['stato_pagamento'])){
                echo "<div class=\"filter-label bg-gray\"><span >Stato Pagamento: ".implode(', ',$_POST['stato_pagamento'])."</span></div>";
            }

            if(isset($_POST['metodo'])){
                echo "<div class=\"filter-label bg-gray\"><span >Stato Pagamento: ".implode(', ',$_POST['metodo'])."</span></div>";
            }

            if(isset($_POST['tipo_pagamento'])){
                echo "<div class=\"filter-label bg-gray\"><span >Tipo Pagamento: ".implode(', ',$_POST['tipo_pagamento'])."</span></div>";
            }

            if(isset($_POST['realizzato_da'])){
                echo "<div class=\"filter-label bg-gray\"><span >realizzato da: ".implode(', ',$_POST['realizzato_da'])."</span></div>";
            }

            if(isset($_POST['bnw'])){
                echo "<div class=\"filter-label bg-gray\"><span >Voucher: ".implode(', ',$_POST['bnw'])."</span></div>";
            }

            if(isset($_POST['stato_saldato_terapista'])){
                echo "<div class=\"filter-label bg-gray\"><span >Stato Saldato Terapista: ".implode(', ',$_POST['stato_saldato_terapista'])."</span></div>";
            } 

            if(isset($_POST['nominativo'])){
                echo "<div class=\"filter-label bg-gray\"><span >Nominativo: ".implode(', ',$_POST['nominativo'])."</span></div>";
            }

            if(!isset($_POST['data_pagamento']['all'])){
                if(isset($_POST['data_pagamento']['da'])){
                    echo "<div class=\"filter-label bg-gray\"><span >Pagamento Da: ".unformat_date($_POST['data_pagamento']['da'])."</span></div>"; 
                }
                if(isset($_POST['data_pagamento']['a'])){
                    echo "<div class=\"filter-label bg-gray\"><span >Pagamento A: ".unformat_date($_POST['data_pagamento']['a'])."</span></div>";    
                }
            } 
            
        ?>
        <button class="btn btn-secondary ms-2" onclick="btnClean()">Pulisci Filtri</button><?php
    }
    ?>
</div>
<div>
    <span><?php echo "Quantità: ".number_format($view_sedute->total,2, ',', '.').", Totale: € ".number_format($sum['prezzo'],2, ',', '.').", Incassato: € ".number_format($sum['saldato'],2, ',', '.').", Pendente: € ".number_format($sum['prezzo']-$sum['saldato'],2, ',', '.'); ?></span>
</div>

<!-- table -->
<?php 
    if(!$view_sedute->result){?>
        <div class="card card-body mt-3 text-center"><h5>Non trovato</h5></div><?php
    }
    else{?>
        <div class="px-1">
            <table class="table table-striped table-hover text-center">
                <thead>
                    <tr class="small">
                        <th class="w-10">Cliente</th>
                        <th class="w-5">Acron.</th>
                        <th class="w-10">Stato Seduta</th>
                        <th class="w-10">Data Seduta</th>
                        <th class="w-10">Data Pag.</th>
                        <th class="w-10">Prezzo</th>
                        <th class="w-10">Saldato</th>
                        <th class="w-10">Stato Pagamento</th>
                        <th class="w-10">Realizzato da</th>
                        <th class="w-20">Terapista</th>
                    </tr>
                </thead>
                <tbody><?php 
                    foreach($view_sedute->result as $seduta){?>
                        <tr data-id=<?php echo $seduta['id']; ?> style="font-size:12px;line-height:8px; word-break:break-word;">
                            <td><?php echo $seduta['nominativo']; ?></td>
                            <td><?php echo $seduta['acronimo']; ?></td>
                            <td><?php echo $seduta['stato_seduta']; ?></td>
                            <td><?php echo $seduta['data_seduta']?format($seduta['data_seduta'],'d/m/y'):'-'; ?></td>
                            <td><?php echo $seduta['data_pagamento']?format($seduta['data_pagamento'],'d/m/y'):'-'; ?></td>
                            <td><?php echo number_format($seduta['prezzo'],2); ?></td>
                            <td><?php echo number_format($seduta['saldato'],2); ?></td>
                            <td><?php echo $seduta['stato_pagamento']; ?></td>
                            <td><?php echo $seduta['realizzato_da']??'-'; ?></td>
                            <td><?php echo $seduta['terapista']; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php
    }
?>
<?php Html()->pagination2($view_sedute,$url); ?>

<!-- floating menu -->
<div class="floating-menu-btn">
    <button class="h-100 left"><?php echo icon('arrow-filled-left.svg'); ?></button>
    <button class="h-100 right"><?php echo icon('arrow-filled-right.svg'); ?></button>
</div>
<div class="floating-input-sedute" onclick="inputExcel()">
    <div class="d-grid tip d-none justify-content-center align-content-center">
        <span>Aggiorna dati delle sedute importando un file excel</span>
    </div>
    <div class="div-icon">
        <?php echo icon('upload.svg','#0d394a',25,25); ?>
    </div>
</div>
<div class="floating-download-pdf-btn" onclick="pdf('sedute','<?php echo session_id(); ?>')">
    <div class="d-grid tip d-none justify-content-center align-content-center">
        <span>Scarrica pdf con le sedute filtrate</span>
    </div>
    <div class="div-icon">
        <?php echo icon('pdf.svg','#0d394a',25,25); ?>
    </div>
</div>
<div class="floating-excel-btn" onclick="excel('post/excel_sedute.php')">
    <div class="d-grid tip d-none justify-content-center align-content-center">
        <span>Scarrica excel con le sedute filtrate</span>
    </div>
    <div class="div-icon">
        <?php echo icon('excel.svg','#0d394a',25,25); ?>
    </div>
</div>

<!-- filters -->
<div class="floating-menu text-center pb-5">
    <div class="content p-0 h-100">
        <div class="pt-3 p-2">
            <h6>FILTRA</h6>
        </div>
        <div class="accordion p-1" id="filter_cliente">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_cliente" aria-expanded="false" aria-controls="collapse_filter_cliente">
                    Cliente
                    </button>
                </h2>
                <div id="collapse_filter_cliente" class="accordion-collapse collapse" data-bs-parent="#filter_cliente">
                    <div class="accordion-body">
                        <div>
                            <label for="cliente">Nominativo Cliente</label>
                            <select class="form-control selectpicker" id="cliente" value="<?php echo isset($_POST['cliente'])?$_POST['cliente']:''; ?>" multiple>
                                <?php 
                                    foreach(Select('*')->from('clienti')->get() as $enum){
                                        $selected = in_array($enum['id'],( $_POST['cliente'] ?? []))?'selected':'';
                                        echo "<option value=\"{$enum['id']}\" {$selected}>{$enum['nominativo']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion p-1" id="filter_data">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_data" aria-expanded="false" aria-controls="collapse_filter_data">
                    Data Seduta
                    </button>
                </h2>
                <div id="collapse_filter_data" class="accordion-collapse collapse" data-bs-parent="#filter_data">
                    <div class="accordion-body">
                        <div>
                            <label for="data_seduta_da">Da</label>
                            <input class="form-control" type="date" id="data_seduta_da" value="<?php echo $_POST['data_seduta']['da']; ?>">
                        </div>
                        <div>
                            <label for="data_seduta_a">A</label>
                            <input class="form-control" type="date" id="data_seduta_a" value="<?php echo $_POST['data_seduta']['a']; ?>">
                        </div>
                        <div class="mt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="data_seduta_all" 
                                    value="<?= isset($_POST['data_seduta']['all']) ? htmlspecialchars($_POST['data_seduta']['all']) : '' ?>" 
                                    <?= !empty($_POST['data_seduta']['all']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="data_seduta_all">
                                    Seleziona tutto
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion p-1" id="filter_data_pagamento">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_data_pagamento" aria-expanded="false" aria-controls="collapse_filter_data_pagamento">
                    Data Pagamento
                    </button>
                </h2>
                <div id="collapse_filter_data_pagamento" class="accordion-collapse collapse" data-bs-parent="#filter_data_pagamento">
                    <div class="accordion-body">
                        <div>
                            <label for="data_pagamento_da">Da</label>
                            <input class="form-control" type="date" id="data_pagamento_da" value="<?php echo isset($_POST['data_pagamento']) ? $_POST['data_pagamento']['da'] : ''; ?>">
                        </div>
                        <div>
                            <label for="data_pagamento_a">A</label>
                            <input class="form-control" type="date" id="data_pagamento_a" value="<?php echo isset($_POST['data_pagamento']) ? $_POST['data_pagamento']['a'] : ''; ?>">
                        </div>
                        <div class="mt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="data_pagamento_all" 
                                    value="<?= isset($_POST['data_pagamento']['all']) ? htmlspecialchars($_POST['data_pagamento']['all']) : '' ?>" 
                                    <?= !empty($_POST['data_pagamento']['all']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="data_pagamento_all">
                                    Seleziona tutto
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion p-1" id="filter_id_terapista">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_terapista" aria-expanded="false" aria-controls="collapse_filter_terapista">
                    Terapista
                    </button>
                </h2>
                <div id="collapse_filter_terapista" class="accordion-collapse collapse" data-bs-parent="#filter_id_terapista">
                    <div class="accordion-body">
                        <div>
                            <label for="id_terapista">Terapista</label>
                            <select class="form-control selectpicker" id="id_terapista" value="<?php echo isset($_POST['id_terapista']) ? $_POST['id_terapista'] : ''; ?>"  multiple>
                                <option value="0" <?= (isset($_POST['id_terapista']) && $_POST['id_terapista'] === "0") ? 'selected' : '' ?>>Non Assegnato</option>
                                <?php 
                                    foreach (Select('*')->from('terapisti')->get() as $terapista) {
                                        $selected = in_array($terapista['id'],( $_POST['id_terapista'] ?? []))?'selected':'';
                                        echo "<option {$selected} value=\"{$terapista['id']}\">{$terapista['terapista']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion p-1" id="filter_stato_seduta">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_stato_seduta" aria-expanded="false" aria-controls="collapse_filter_stato_seduta">
                    Stato Seduta
                    </button>
                </h2>
                <div id="collapse_filter_stato_seduta" class="accordion-collapse collapse" data-bs-parent="#filter_stato_seduta">
                    <div class="accordion-body">
                        <div>
                            <label for="stato_seduta">Stato Seduta</label>
                            <select class="form-control selectpicker" id="stato_seduta" value="<?php echo isset($_POST['stato_seduta']) ? $_POST['stato_seduta'] : ''; ?>" multiple>
                                <?php 
                                    foreach (Enum('percorsi_terapeutici_sedute_prenotate','stato_prenotazione')->get() as $enum) {
                                        $selected = in_array($enum,( $_POST['stato_seduta'] ?? []))?'selected':'';
                                        echo "<option {$selected} value=\"{$enum}\">{$enum}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion p-1" id="filter_stato_saldato_terapista">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_stato_saldato_terapista" aria-expanded="false" aria-controls="collapse_filter_stato_saldato_terapista">
                    Stato Pagamento Terapista
                    </button>
                </h2>
                <div id="collapse_filter_stato_saldato_terapista" class="accordion-collapse collapse" data-bs-parent="#filter_stato_saldato_terapista">
                    <div class="accordion-body">
                        <div>
                            <label for="stato_saldato_terapista">Pagamento Terapista</label>
                            <select class="form-control selectpicker" id="stato_saldato_terapista" value="<?php echo isset($_POST['stato_saldato_terapista']) ? $_POST['stato_saldato_terapista'] : ''; ?>" multiple>
                                <?php 
                                    foreach (Enum('percorsi_terapeutici_sedute','stato_saldato_terapista')->get() as $enum) {
                                        $selected = in_array($enum,( $_POST['stato_saldato_terapista'] ?? []))?'selected':'';
                                        echo "<option {$selected} value=\"{$enum}\">{$enum}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion p-1" id="filter_realizzato_da">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_realizzato_da" aria-expanded="false" aria-controls="collapse_filter_realizzato_da">
                    Realizzato da
                    </button>
                </h2>
                <div id="collapse_filter_realizzato_da" class="accordion-collapse collapse" data-bs-parent="#filter_realizzato_da">
                    <div class="accordion-body">
                        <div>
                            <label for="realizzato_da">Realizzato da</label>
                            <select class="form-control selectpicker" id="realizzato_da" value="<?php echo isset($_POST['realizzato_da']) ? $_POST['realizzato_da'] : ''; ?>" multiple>
                                <?php 
                                    foreach (Enum('percorsi_terapeutici','realizzato_da')->get() as $enum) {
                                        $selected = in_array($enum,( $_POST['realizzato_da'] ?? []))?'selected':'';
                                        echo "<option {$selected} value=\"{$enum}\">{$enum}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion p-1" id="filter_stato_pagamento">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_stato_pagamento" aria-expanded="false" aria-controls="collapse_filter_stato_pagamento">
                    Stato Pagamento
                    </button>
                </h2>
                <div id="collapse_filter_stato_pagamento" class="accordion-collapse collapse" data-bs-parent="#filter_stato_pagamento">
                    <div class="accordion-body">
                        <div>
                            <label for="stato_pagamento">Stato Pagamento</label>
                            <select class="form-control selectpicker" id="stato_pagamento" value="<?php echo isset($_POST['stato_pagamento']) ? $_POST['stato_pagamento'] : ''; ?>" multiple>
                                <?php 
                                    foreach (Enum('percorsi_terapeutici_sedute','stato_pagamento')->get() as $enum) {
                                        $selected = in_array($enum,( $_POST['stato_pagamento'] ?? []))?'selected':'';
                                        echo "<option {$selected} value=\"{$enum}\">{$enum}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion p-1" id="filter_tipo_pagamento">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_tipo_pagamento" aria-expanded="false" aria-controls="collapse_filter_tipo_pagamento">
                    Tipo Pagamento
                    </button>
                </h2>
                <div id="collapse_filter_tipo_pagamento" class="accordion-collapse collapse" data-bs-parent="#filter_tipo_pagamento">
                    <div class="accordion-body">
                        <div>
                            <label for="tipo_pagamento">Tipo Pagamento</label>
                            <select class="form-control selectpicker" id="tipo_pagamento" value="<?php echo isset($_POST['tipo_pagamento']) ? $_POST['tipo_pagamento'] : ''; ?>" multiple>
                                <?php 
                                    foreach (Enum('percorsi_terapeutici_sedute','tipo_pagamento')->get() as $enum) {
                                        $selected = in_array($enum,( $_POST['tipo_pagamento'] ?? []))?'selected':'';
                                        echo "<option {$selected} value=\"{$enum}\">{$enum}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion p-1" id="filter_metodo">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_metodo" aria-expanded="false" aria-controls="collapse_filter_metodo">
                    Metodo Pagamento
                    </button>
                </h2>
                <div id="collapse_filter_metodo" class="accordion-collapse collapse" data-bs-parent="#filter_metodo">
                    <div class="accordion-body">
                        <div>
                            <label for="metodo">Metodo Pagamento</label>
                            <select class="form-control selectpicker" id="metodo" value="<?php echo isset($_POST['metodo']) ? $_POST['metodo'] : ''; ?>" multiple>
                                <?php 
                                    foreach (Enum('pagamenti','metodo')->get() as $enum) {
                                        $selected = in_array($enum,( $_POST['metodo'] ?? []))?'selected':'';
                                        echo "<option {$selected} value=\"{$enum}\">{$enum}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion p-1" id="filter_bnw">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_filter_bnw" aria-expanded="false" aria-controls="collapse_filter_bnw">
                    Voucher
                    </button>
                </h2>
                <div id="collapse_filter_bnw" class="accordion-collapse collapse" data-bs-parent="#filter_bnw">
                    <div class="accordion-body">
                        <div>
                            <label for="bnw">Voucher</label>
                            <select class="form-control selectpicker" id="bnw" value="<?php echo $_POST['bnw']; ?>" multiple>
                                <?php 
                                    foreach (Enum('percorsi_terapeutici','bnw')->get() as $enum) {
                                        $selected = in_array($enum,( $_POST['bnw'] ?? []))?'selected':'';
                                        echo "<option {$selected} value=\"{$enum}\">{$enum}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sticky-bottom w-100" onclick="btnFiltra()">
        <button class="btn btn-primary w-100">Filtra</button>
    </div>
</div>