<?php $result=($id=request('id'))?$result=Select('*')->from('trattamenti')->where("id={$id}")->first_or_false():false;?>
<div class="p-2">
    <input type="text" id="id" name="id" value="<?php echo $result['id']??'';?>" hidden/>
    <div class="mb-3">
        <label for="tipo" class="form-label">Categoria</label>
        <select type="text" class="form-control" id="tipo" name="categoria" value="<?php echo $result['categoria']??'';?>">
            <?php 
                echo "<option value=\"\" class=\"ps-4  bg-white\"></option>";
                foreach(Enum('trattamenti','categoria')->list as $value){
                    $selected = (isset($result['id']) && $result['categoria'] == $value) ? 'selected' : '';
                    echo "<option value=\"{$value}\" class=\"ps-4  bg-white\" {$selected}>{$value}</option>";
                }
            ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="trattamento" class="form-label">Nome</label>
        <input type="text" class="form-control" id="trattamento" name="trattamento" value="<?php echo $result['trattamento']??'';?>"/>
    </div>
    <div class="mb-3">
        <label for="tipo" class="form-label">Tipo</label>
        <select type="text" class="form-control" id="tipo" name="tipo" value="<?php echo $result['tipo']??'';?>">
            <?php 
                echo "<option value=\"\" class=\"ps-4  bg-white\"></option>";
                foreach(Enum('trattamenti','tipo')->list as $value){
                    $selected = (isset($result['id']) && $result['tipo'] == $value) ? 'selected' : '';
                    echo "<option value=\"{$value}\" class=\"ps-4  bg-white\" {$selected}>{$value}</option>";
                }
            ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="prezzo" class="form-label">Prezzo</label>
        <input type="number" class="form-control" id="prezzo" name="prezzo" value="<?php echo $result['prezzo']??'';?>"/>
    </div>
</div>