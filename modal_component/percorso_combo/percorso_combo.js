window.modalHandlers['percorso_combo']={
    prezzo_picked:false,
    prezzo:0,
    refreshModal:function(_data){
        reload_modal_component('percorsi','percorsi',_data);
    },
    btnSalva:function(element,id_cliente,id_percorso,id_combo){
        console.log(id_combo);
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
            this.refreshModal({id_cliente:id_cliente});
        }).fail(()=>{fail();})
        
    },
    delEnter:function(element){
        element.closest('.d-flex').classList.add('bg-danger');
        element.querySelector('svg').setAttribute('fill', 'white');
    },
    delLeave:function(element){
        element.closest('.d-flex').classList.remove('bg-danger');
        element.querySelector('svg').setAttribute('fill', 'back');
    },
    delClick:function(element){
        const modal = element.closest('.modal');
        element.closest('.d-flex').remove();
        this.refreshPage(modal);
    },
    addTrattamento:function(element){
        const modal = element.closest('.modal');
        const id_trattamento = modal.querySelector('[name=add_trattamento]').value;
        if(id_trattamento==''){
            alert('Seleziona trattamento');
        }
        else{
            $.post('post/add_trattamento.php',{id_trattamento:id_trattamento}).done(response=>{
                let div = document.createElement('div');
                div.classList = 'd-flex flex-row';
                div.innerHTML = response;
                modal.querySelector('#table-body').append(div);
                this.refreshPage(modal);
            }).fail(()=>{fail();});
        }
    },
    refreshPage:function(modal){
        let acronimo = [];
        let prezzo_tabellare = 0;
        let index = 0;
        modal.querySelectorAll('[name=row_acronimo]').forEach(element=>{
            acronimo.push(element.value);
            index++;
        });
        modal.querySelectorAll('[name=row_prezzo_tabellare]').forEach(element=>{
            prezzo_tabellare+=parseInt(element.value);
        });
        if(this.prezzo_picked){
            let factor = prezzo_tabellare-this.prezzo;
            let difference = factor;
            modal.querySelectorAll('[name=row_prezzo]').forEach(element=>{
                let tabellare = parseInt(element.getAttribute('prezzo_tabellare'));
                let value = tabellare;
                if(factor==0){
                    element.value = tabellare;
                }
                else if(factor>0){
                    value-=difference;
                    difference-=tabellare;
                    if(difference<0)difference=0;

                    if(value<=0){
                        element.value = 0;
                    }
                    else{
                        element.value = value;
                    }
                }
                else if(factor<0){
                    element.value = tabellare + (factor*-1/index);
                }
            });
        }
        else{
            modal.querySelector('[name=prezzo]').value = prezzo_tabellare;
        }
        modal.querySelector('[name=acronimo]').value = acronimo.join(' - ');
        modal.querySelector('[name=prezzo_tabellare]').value = prezzo_tabellare;
    },
    changePrezzo:function(element){
        const modal = element.closest('.modal');
        this.prezzo_picked = true;
        this.prezzo = element.value;
        this.refreshPage(modal);
    },
}
