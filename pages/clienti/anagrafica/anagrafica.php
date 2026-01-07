<div class="d-flex flex-row p-2">
    <div class= "d-w20" onclick="add();">
        <button type="button" class="btn btn-primary p-2 d-flex flex-row btn-insert w-100 h-100">
            <div class="mx-2"><?php echo icon('cloud-add.svg','white',20,20);?></div>
            <div>Aggiungi</div>
        </button>
    </div>
    <div class= "ms-2 d-w20" onclick="excel('pages/clienti/anagrafica/post/excel_anagrafica.php');">
        <button type="button" class="btn btn-secondary p-2 d-flex flex-row btn-insert w-100 h-100">
            <div class="mx-2"><?php echo icon('excel.svg','white',20,20);?></div>
            <div>Esporta</div>
        </button>
    </div>
</div>
<div class="w-100 mx-1" id="search_table"></div>
<?php script('pages/clienti/anagrafica/anagrafica.js'); ?>