<?php 
    $trattamenti = Select('t.*')
        ->from('trattamenti', 't')
        ->orderby('t.tipo, t.categoria, t.trattamento ASC')
        ->get(); 
?>
<div class="mb-3 ms-2">
    <label for="id_trattamento" class="form-label">Trattamento</label>
    <select class="form-select" id="id_trattamento" name="id_trattamento" value="<?php echo $result['id_trattamento']??''; ?>">
        <?php 
            $current_tipo = $current_categoria = '';
            echo "<option value=\"\" class=\"ps-4  bg-white\" prezzo=\"\" tipo=\"\"></option>";
            foreach ($trattamenti as $trattamento) {
                if ($current_categoria && $current_categoria != $trattamento['categoria']) {
                    echo "</optgroup>";
                    $current_categoria = '';
                }

                if ($current_tipo && $current_tipo != $trattamento['tipo']) {
                    if ($current_categoria) {
                        echo "</optgroup>";
                    }
                    echo "</optgroup>";
                    $current_tipo = '';
                }

                if ($current_tipo != $trattamento['tipo']) {
                    $current_tipo = $trattamento['tipo'];
                    echo "<optgroup label=\"*{$trattamento['tipo']}\" class=\"fw-bold\">";
                }

                if ($current_categoria != $trattamento['categoria']) {
                    $current_categoria = $trattamento['categoria'];
                    echo "<optgroup label=\"-- {$trattamento['categoria']}\" class=\"ps-3 bg-primary-7\">";
                }

                $selected = (isset($result['id_trattamento']) && $result['id_trattamento'] == $trattamento['id']) ? 'selected' : '';
                echo "<option value=\"{$trattamento['id']}\" class=\"ps-4 bg-white\" prezzo=\"{$trattamento['prezzo']}\" tipo=\"{$trattamento['tipo']}\" $selected>{$trattamento['trattamento']}</option>";            
            }

            if ($current_categoria) echo "</optgroup>";
            if ($current_tipo) echo "</optgroup>";
        ?>
    </select>
</div>
<div class="mb-3 ms-2" id="sedute" <?php echo $result?'':'hidden'?>>
    <label for="sedute" class="form-label">Sedute</label>
    <input type="number" class="form-control" id="sedute" name="sedute" value="<?php echo $result['sedute']??'1'; ?>"> 
</div>
<div class="mb-3 ms-2" id="prezzo" <?php echo $result?'':'hidden'?>>
    <label for="prezzo" class="form-label" >Prezzo</label>
    <input type="number" class="form-control" id="prezzo" name="prezzo" value="<?php echo $result['prezzo']??''; ?>"> 
</div>
