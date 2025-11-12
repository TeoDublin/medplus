window.modalHandlers['fattura_cambia_stato']={
    changeStato:function(element){
        const save = element.closest('.modal').querySelector('.save');
        let dataRow = save.querySelector('#data-row');
        if(save.querySelector('#stato').value == 'Pendente'){
            dataRow.querySelector('#data').value = '';
            if(!dataRow.classList.contains('d-none')){
                dataRow.classList.add('d-none');
            }
        }
        else{
            dataRow.classList.remove('d-none');
        }
    },
    btnSalva:function(element){
        const save = element.closest('.modal').querySelector('.save');
        let _data = save.dataset;
        save.querySelectorAll('[name]').forEach(element=>{ _data[element.name]=element.value;});
        $.post('post/fattura_cambia_stato.php',_data).done(function(){ 
            reload_modal_component('percorsi_fatture','percorsi_fatture',{id_cliente:_data.id_cliente});
        }).fail(function(){
            fail()
        });
    }
} 
