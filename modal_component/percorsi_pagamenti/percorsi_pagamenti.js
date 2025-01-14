window.modalHandlers['percorsi_pagamenti'] = {
    enterRow:function(element){
        element.closest('div.fattura_row').classList.add('success');
    },
    leaveRow:function(element){
        element.closest('div.fattura_row').classList.remove('success');
    },
    clickRow:function(element){
        let row = element.closest('div.fattura_row');
        let check = row.querySelector('#id_percorso');
        if (check.checked) {
            check.checked = false;
            row.classList.remove('checked');
        } else {
            check.checked = true;
            row.classList.add('checked');
        }
    },
    enterPrezzo:function(element){
        element.classList.add('success');
    },
    leavePrezzo:function(element){
        element.classList.remove('success');
    },
    clickPrezzo:function(id_percorso,id_cliente){
        modal_component('percorso_terapeutico','percorso_terapeutico',{id_cliente:id_cliente,caller:'percorsi_pagamenti',id_percorso:id_percorso});
    },
    fatturaClick:function(element,id_cliente){
        modal = element.closest('.modal');
        _data=[];
        modal.querySelectorAll('.checked').forEach(checked => {
            _data.push({
                id_percorso:checked.querySelector('#id_percorso').value, 
                oggetto:checked.querySelector('#trattamento').innerHTML, 
                importo:checked.querySelector('#non_fatturato').innerHTML
            });
        });
        if(_data.length === 0){
            alert('Seleziona qualcosa');
        }
        else{
            modal_component('fattura','fattura',{id_cliente:id_cliente,oggetti:_data});
        }
    },
    senzaFatturaClick:function(element,id_cliente){
        modal = element.closest('.modal');
        _data=[];
        modal.querySelectorAll('.checked').forEach(checked => {
            _data.push({
                id_percorso:checked.querySelector('#id_percorso').value, 
                importo:checked.querySelector('#prezzo').innerHTML
            });
        });
        if(_data.length === 0){
            alert('Seleziona qualcosa');
        }
        else{
            modal_component('senza_fattura','senza_fattura',{id_cliente:id_cliente,_data:_data});
        }
    }
}