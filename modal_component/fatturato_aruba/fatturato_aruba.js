window.modalHandlers['fatturato_aruba']={
    btnSalva:function(element,_percorsi){
        let _data = {};
        const mnodal = element.closest('.modal');
        mnodal.querySelectorAll('[name]').forEach(element=>{ _data[element.name]=element.value;});
        $.post('post/fatturato_aruba.php',{percorsi:_percorsi,_data:_data}).done(function(){ 
            reload_modal_component('percorsi_pendenze','percorsi_pendenze',{id_cliente:_data['id_cliente']});
        }).fail(function(){fail()});
    },
    switchInps:function(e){
        let valore = e.closest('.modal').querySelector('#valore').value;
        let inps = e.closest('.modal').querySelector('#inps');
        e.classList.toggle('active');
        if(e.classList.contains('active')){
            inps.value = valore * 0.04;
        }
        else{
           inps.value = 0;
        }
    },
    switchBollo:function(e){
        let bollo = e.closest('.modal').querySelector('#bollo');
        e.classList.toggle('active');
        if(e.classList.contains('active')){
            bollo.value = 2.0;
        }
        else{
           bollo.value = 0;
        }
    }
}