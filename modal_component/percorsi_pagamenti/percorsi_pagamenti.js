window.modalHandlers['percorsi_pagamenti'] = {
    clickRow:function(element){
        let check = element.querySelector('#id_percorso');
        if (check.checked) {
            check.checked = false;
            element.classList.remove('checked');
        } else {
            check.checked = true;
            element.classList.add('checked');
        }
    },
    fatturaClick:function(element,id_cliente){
        modal = element.closest('.modal');
        _data=[];
        modal.querySelectorAll('.checked').forEach(checked => {
            _data.push({
                id_percorso:checked.querySelector('#id_percorso').value, 
                oggetto:checked.querySelector('#trattamento').innerHTML, 
                importo:checked.querySelector('#prezzo').innerHTML
            });
        });
        if(_data.length === 0){
            alert('Seleziona qualcosa');
        }
        else{
            modal_component('fattura','fattura',{id_cliente:id_cliente,oggetti:_data});
        }
    }
}