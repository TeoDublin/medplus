<div class="p-2">
    <input type="text" name="tab" value="sbarra" hidden/>
    <div class="my-3 ms-2">
        <label for="sbarra" class="form-label">Motivo</label>
        <select class="form-select" id="sbarra" name="sbarra" onchange="test();">
            <option value="sbarra" class="ps-4  bg-white"></option>
            <option value="sbarra" class="ps-4  bg-white">Sbarra</option>
            <option value="pranzo" class="ps-4  bg-white">Pranzo</option>
            <option value="corso" class="ps-4  bg-white">Corso</option>
        </select>
    </div>
</div>
<?php  script('page_components/customer-picker/sbarra/sbarra.js');?>