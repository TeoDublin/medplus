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
        const modal = element.closest('.modal');
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
    enterPrezzo:function(element){
        element.classList.add('success');
    },
    leavePrezzo:function(element){
        element.classList.remove('success');
    },
    loadScript:function(url, callback) {
        const script = document.createElement('script');
        script.src = url;
        script.onload = callback;
        document.head.appendChild(script);
    },
    clickPrezzoTrattamenti: function(id_percorso, id_cliente) {
        const id = 'percorso_combo';
        const component = 'percorso_combo';
        const _data = { id_cliente: id_cliente, caller: 'percorsi_pendenze', id_percorso: id_percorso };
        const modal_id = 'modal_' + component;
        _data['id_modal'] = modal_id;
        _data['component'] = component;
    
        if (!window.modalHandlers['percorso_combo']) {
            this.loadScript('modal_component/percorso_combo/percorso_combo.js', () => {
                console.log('Modal script loaded');
                openModal();
            });
        } else {
            console.log('Modal handler already exists');
            openModal();
        }
    
        function openModal() {
            $.post('modal_component.php', _data).done(html => {
                const container = document.querySelector('#' + id);
                document.querySelectorAll('#div_' + component).forEach(to_remove => { to_remove.remove(); });
    
                const div = document.createElement('div');
                div.id = 'div_' + component;
                div.innerHTML = html;
                append_scripts(div);
                container.appendChild(div);
    
                const modalElement = document.getElementById(modal_id);
                const newModalInstance = new bootstrap.Modal(modalElement, { keyboard: false });
    
                modalElement.addEventListener('shown.bs.modal', () => {
                    console.log('Modal shown');
    
                    // Debugging: Check if modalHandlers['percorso_combo'] exists
                    if (window.modalHandlers['percorso_combo']) {
                        console.log('Handler exists:', window.modalHandlers['percorso_combo']);
    
                        // Log if refreshModal is already set
                        console.log('Current refreshModal:', window.modalHandlers['percorso_combo'].refreshModal);
    
                        // Reassign refreshModal function
                        window.modalHandlers['percorso_combo'].refreshModal = function(_data) {
                            console.log('New refreshModal function triggered');
                            reload_modal_component('percorsi_pendenze', 'percorsi_pendenze', _data);
                        };
    
                        // Ensure that other properties are set
                        window.modalHandlers['percorso_combo'].prezzo_picked = true;
                        window.modalHandlers['percorso_combo'].prezzo = modalElement.querySelector('[name=prezzo]').value;
                        window.modalHandlers['percorso_combo'].refreshPage(modalElement);
                    } else {
                        console.error("modalHandlers['percorso_combo'] is not loaded yet.");
                    }
                });
    
                newModalInstance.show();
            });
        }
    }, 
    clickPrezzoCorsi:function(id,prezzo_tabellare,prezzo,id_cliente){
        modal_component('prezzo_corso','prezzo_corso',{id:id,prezzo_tabellare:prezzo_tabellare,prezzo:prezzo,id_cliente:id_cliente});
    },
    fatturaClick:function(element,id_cliente){
        modal = element.closest('.modal');
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
                modal_component('fattura','fattura',{id_cliente:id_cliente,oggetti:oggetti,cliente:cliente});
            }
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