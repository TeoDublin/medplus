window.modalHandlers['percorso_combo'] = Object.assign(
    window.modalHandlers['percorso_combo'] || {}, {
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
        if(modal.querySelectorAll('.row-trattamenti').length == 0 ){
            modal.querySelector('.trattamenti-empty').classList.remove('d-none');
            modal.querySelector('.trattamenti-titles').classList.add('d-none');
        }
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
                div.classList = 'd-flex flex-row row-trattamenti';
                div.innerHTML = response;
                modal.querySelector('#table-body').append(div);
                modal.querySelector('.trattamenti-empty').classList.add('d-none');
                modal.querySelector('.trattamenti-titles').classList.remove('d-none');
                this.refreshPage(modal);
            }).fail(()=>{fail();});
        }
    },
    changePrezzo:function(element){
        const modal = element.closest('.modal');
        this.prezzo_picked = true;
        this.prezzo_a_sedute = element.value;
        modal.querySelector('[name=sedute]').removeAttribute('disabled');
    },
    changeSedute:function(element){
        const modal = element.closest('.modal');
        let new_value = element.value===0 ? 0 : element.value * this.prezzo_a_sedute;
        modal.querySelector('[name=prezzo]').value = new_value;
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
        modal.querySelector('[name=acronimo]').value = acronimo.join(' - ');
        modal.querySelector('[name=prezzo_tabellare]').value = prezzo_tabellare;
    },
});
