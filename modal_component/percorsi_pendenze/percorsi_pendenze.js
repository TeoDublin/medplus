window.modalHandlers['percorsi_pendenze'] = {
    deletePersistent:'fattura',
    doing_isico:false,
    is_clicked:false,
    enterRow:function(element,is_isico){
        element.closest('div.fattura_row').classList.add('success');
    },
    leaveRow:function(element,is_isico){
        element.closest('div.fattura_row').classList.remove('success');
    },
    clickRow:function(element,is_isico){
        const modal = element.closest('.modal');
        if(is_isico&&!this.doing_isico&&!this.is_clicked)this.doing_isico=true;
        if(is_isico&&!this.doing_isico||!is_isico&&this.doing_isico){
            alert("I trattamenti Isico non possono essere fatturati insieme ai altri");
            return;
        }
        this.is_clicked=true;
        let row = element.closest('div.fattura_row');
        let check = row.querySelector('#id_percorso');
        if (check.checked) {
            check.checked = false;
            row.classList.remove('checked');
            if(modal.querySelectorAll('.checked').length==0){
                this.doing_isico=false;
                this.is_clicked=false;
            }
        } else {
            check.checked = true;
            row.classList.add('checked');
        }
        let sum_selected = 0;
        modal.querySelectorAll('.checked').forEach(checked_div=>{
            sum_selected+=parseFloat(checked_div.querySelector('#non_fatturato').innerHTML) || 0;
        });
        let span_Sum_selected = modal.querySelector('#sum-selected');
        if(sum_selected===0){
            span_Sum_selected.classList.add('d-none');
        }
        else{
            span_Sum_selected.classList.remove('d-none');
            let formattedSum = sum_selected.toFixed(2).replace('.', ',');
            span_Sum_selected.innerHTML='SELEZIONATO: '+formattedSum;
        }
    },
    enterDel:function(element){
        element.closest('div.fattura_row').classList.add('warning');
    },
    leaveDel:function(element){
        element.closest('div.fattura_row').classList.remove('warning');
    },
    clickDel:function(id,id_cliente){
        $.post('post/delete.php',{table:'corsi_pagamenti',id:id}).done(()=>{
            reload_modal_component('percorsi_pendenze','percorsi_pendenze',{id_cliente:id_cliente});
        }).fail(()=>{fail()});
    },
    clickDelAlert:function(){
        alert('Non puoi eliminare una pendenza gia fatturata');
    },
    enterPrezzo:function(element){
        element.classList.add('success');
    },
    leavePrezzo:function(element){
        element.classList.remove('success');
    },
    clickPrezzoTrattamenti: function(element,id_percorso, id_cliente) {
        const modal = element.closest('.modal');
        window.modalHandlers['percorso_combo']={
            prezzo_picked:true,
            prezzo_a_sedute:modal.querySelector('#prezzo').innerHTML,
            btnSalva:function(element,id_cliente,id_percorso,id_combo){
                const modal = element.closest('.modal');
                let _data = {
                    trattamenti:[],
                    prezzo_tabellare:modal.querySelector('[name=prezzo_tabellare]').value,
                    prezzo:modal.querySelector('[name=prezzo]').value,
                    note:modal.querySelector('[name=note]').value,
                    sedute:modal.querySelector('[name=sedute]').value,
                    id_cliente:id_cliente,
                    id_percorso:id_percorso,
                    id_combo:id_combo
                };
                modal.querySelectorAll('[name=id_trattamento]').forEach(element=>{
                    _data.trattamenti.push(element.value);
                });
                $.post('post/percorso_terapeutico.php',_data).done(()=>{
                    reload_modal_component('percorsi_pendenze','percorsi_pendenze',{id_cliente:id_cliente});
                }).fail(()=>{fail();})
            },
        }
        modal_component('percorso_combo','percorso_combo',{id_cliente:id_cliente,id_percorso:id_percorso});
    }, 
    clickPrezzoCorsi:function(id,prezzo_tabellare,prezzo,id_cliente){
        modal_component('prezzo_corso','prezzo_corso',{id:id,prezzo_tabellare:prezzo_tabellare,prezzo:prezzo,id_cliente:id_cliente});
    },
    fatturaClick:function(element,id_cliente){
        const modal = element.closest('.modal');
        let oggetti=[];
        const { idNominativo, idIndirizzo, idCap, idCitta, idCf } = element.dataset;
        let error = 'Per generare la fattura devi inserire i dati:\n\n';
        let hasError=false;
        if(!idNominativo||idNominativo==''){
            hasError=true;
            error+='- Nominativo\n';
        }
        if(!idIndirizzo||idIndirizzo==''){
            hasError=true;
            error+='- Indirizzo\n';
        }
        if(!idCap||idCap==''){
            hasError=true;
            error+='- Cap\n';
        }
        if(!idCitta||idCitta==''){
            hasError=true;
            error+='- Citta\n';
        }
        if(!idCf||idCf==''){
            hasError=true;
            error+='- Codice fiscale\n';
        }
        if(hasError){
            alert(error);
        }
        else{
            modal.querySelectorAll('.checked').forEach(checked => {
                oggetti.push({
                    origine:checked.getAttribute('origine'),
                    id_percorso:checked.querySelector('#id_percorso').value, 
                    oggetto:checked.querySelector('#trattamento').value, 
                    importo:checked.querySelector('#non_fatturato').innerHTML
                });
            });
            const cliente = {
                nominativo:idNominativo,
                indirizzo:idIndirizzo,
                cap:idCap,
                citta:idCitta,
                cf:idCf
            }
            if(oggetti.length === 0){
                alert('Seleziona qualcosa');
            }
            else{
                modal_component('fattura','fattura',{id_cliente:id_cliente,oggetti:oggetti,cliente:cliente,is_isico:this.doing_isico});
            }
        }
    },
    senzaFatturaClick:function(element,id_cliente){
        console.log(this.doing_isico);
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
        else if(this.doing_isico){
            modal_component('pagamento_isico','pagamento_isico',{id_cliente:id_cliente,_data:_data});
        }
        else{
            modal_component('senza_fattura','senza_fattura',{id_cliente:id_cliente,_data:_data});
        }
    },
    arubaClick:function(element,id_cliente){
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
            modal_component('fatturato_aruba','fatturato_aruba',{id_cliente:id_cliente,_data:_data});
        }
    }
}
window.modalHandlers['fattura'] = Object.assign(
    window.modalHandlers['fattura'] || {},{
    persistent:true,

    generatePDF:function(e,id_cliente,oggetti) {
        const _oggetti=JSON.parse(oggetti);
        $.post('post/fattura.php',{..._data(e), ..._oggetti}).done(response=>{
            window.open(response,'_blank');
            reload_modal_component('percorsi_pendenze','percorsi_pendenze',{id_cliente:id_cliente});
        });
    },
});