<div class="p-2">
    <input type="text" name="tab" value="sbarra" hidden/>
    <input type="text" id="tabella_riferimento" name="tabella_riferimento" value="motivi" hidden/>
    <div class="my-3 ms-2">
        <label for="sbarra" class="form-label">Motivo</label>
        <select class="form-select" id="id_riferimento" name="id_riferimento" onchange="test();">
            <?php foreach (Select('*')->from('motivi')->get() as $value) {
                echo "<option value=\"{$value['id']}\" class=\"ps-4  bg-white\">{$value['motivo']}</option>";
            }?>
        </select>
    </div>
</div>
<?php  script('page_components/customer-picker/sbarra/sbarra.js');?>