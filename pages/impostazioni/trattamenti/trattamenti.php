<div class="d-flex flex-row p-2">
    <div class= "w-20" onclick="add(false);">
        <button type="button" class="btn btn-primary p-2 d-flex flex-row btn-insert w-100 h-100">
            <div class="mx-2"><?php echo icon('cloud-add.svg','white',20,20);?></div>
            <div>Aggiungi</div>
        </button>
    </div>
    <div class="w-30">
        <div class="p-2 d-flex flex-row ms-3 w-100 bg-primary rounded py-1 h-100">
            <div class="mx-2"><?php echo icon('search.svg','white',20,35);?></div>
            <input class="w-100 " placeholder="Cerca" class="input-search" value="" oninput="search(this.value)"/>
        </div>
    </div>
</div>
<div class="w-100 mx-1" id="search_table"></div>
<?php script('pages/impostazioni/trattamenti/trattamenti.js'); ?>