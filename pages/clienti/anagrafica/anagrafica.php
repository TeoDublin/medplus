<div class="d-flex flex-row p-2">
    <div class= "w-20" onclick="add(false);">
        <button type="button" class="btn btn-primary p-2 d-flex flex-row btn-insert w-100 h-100">
            <div class="mx-2"><?php echo icon('cloud-add.svg','white',20,20);?></div>
            <div>Aggiungi</div>
        </button>
    </div>
</div>
<div class="w-100 mx-1" id="search_table"></div>
<div id="percorsi"></div>
<div id="percorsi_pagamenti"></div>
<div id="percorsi_fatture"></div>
<?php script('pages/clienti/anagrafica/anagrafica.js'); ?>