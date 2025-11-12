<?php 
    function _table(){
        switch ($_REQUEST['origine']) {

            case 'fatture':{
                $ret = 'fatture';
                break;
            }
            case 'isico':{
                $ret = 'pagamenti_isico';
                break;
            }
            case 'senza_fattura':{
                $ret = 'pagamenti_senza_fattura';
                break;
            }
            case 'aruba':{
                $ret = 'pagamenti_aruba';
                break;
            }
            default:{
                throw new Exception("Error Processing Request", 1);
                exit();
                break;
            }

        }
        return $ret;
    }

    $table = _table();

    if(!isset($_REQUEST['id'])){
        echo "Accesso Negato";
        exit();
    }
    else{
        $pagamento=Select('*')->from('pagamenti')->where("id={$_REQUEST['id']}")->first_or_false();
    }

    $d_none = ! isset($pagamento['stato']) || $pagamento['stato'] == 'Pendente' ? 'd-none' : '';

?>
<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Cambia Stato</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body save"
                data-id="<?php echo $_REQUEST['id']??''; ?>"
                data-origine="<?php echo $_REQUEST['origine']??''; ?>"
                data-table="<?php echo $table;?>"
                data-id_cliente="<?php echo $_REQUEST['id_cliente'];?>"
                >

                <div class="d-flex flex-row">
                    <div class="p-2 flex-fill">
                        <label class="form-label" for="stato">Stato</label>
                        <?php 
                            echo "<select 
                                id=\"stato\"
                                class=\"form-control text-center\" name=\"stato\" value=\"{$pagamento['stato']}\"
                                onchange=\"window.modalHandlers['fattura_cambia_stato'].changeStato(this)\"
                                >";
                                foreach(Enum('fatture','stato')->get() as $enum){
                                    $selected=$pagamento['stato']==$enum?'selected':'';
                                    echo "<option value=\"{$enum}\" {$selected}>{$enum}</option>";
                                }
                            echo "</select>";
                        ?>
                    </div>
                </div>

                <div class="d-flex flex-row <?php echo $d_none;?>" id="data-row">
                    <div class="p-2 flex-fill">
                        <label class="form-label" for="data">Data</label>
                        <input class="form-control" name="data" id="data" value="<?php echo $pagamento['data'];?>" type="date"/>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['fattura_cambia_stato'].btnSalva(this)">Salva</a>
            </div>
        </div>
    </div>
</div>
<?php modal_script('fattura_cambia_stato'); ?>