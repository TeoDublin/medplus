window.modalHandlers['percorsi_pendenze'] = {
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
    clickPrezzoTrattamenti:function(id_percorso,id_cliente){
        modal_component('percorso_terapeutico','percorso_terapeutico',{id_cliente:id_cliente,caller:'percorsi_pendenze',id_percorso:id_percorso});
    },
    clickPrezzoCorsi:function(id,prezzo_tabellare,prezzo,id_cliente){
        modal_component('prezzo_corso','prezzo_corso',{id:id,prezzo_tabellare:prezzo_tabellare,prezzo:prezzo,id_cliente:id_cliente});
    },
    fatturaClick:function(element,id_cliente){
        modal = element.closest('.modal');
        _data=[];
        modal.querySelectorAll('.checked').forEach(checked => {
            _data.push({
                origine:checked.getAttribute('origine'),
                id_percorso:checked.querySelector('#id_percorso').value, 
                oggetto:checked.querySelector('#trattamento').value, 
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
                origine:checked.getAttribute('origine'),
                id_percorso:checked.querySelector('#id_percorso').value, 
                non_fatturato:checked.querySelector('#non_fatturato').innerHTML
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