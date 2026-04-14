window.modalHandlers['fatturato_aruba']={
    btnSalva:function(element,_percorsi){
        let _data = {};
        let mnodal = element.closest('.modal');

        modal.querySelectorAll('.error').forEach((element)=>{
            element.classList.remove('error');
        });

        mnodal.querySelectorAll('[name]').forEach(element=>{ 
            _data[element.name]=element.value;
        });

        if(!_data['fattura_aruba']){

            let div_fattura_aruba = document.querySelector('div#div_fattura_aruba');
            console.log(div_fattura_aruba);

            if(div_fattura_aruba){
                div_fattura_aruba.classList.add('div_error');
            }

            alert('Fattura Aruba è obbligatorio');
           
        }
        else{
            $.post('post/fatturato_aruba.php',{percorsi:_percorsi,_data:_data})
            .done(function(){ 
                reload_modal_component('percorsi_pendenze','percorsi_pendenze',{id_cliente:_data['id_cliente']});
            })
            .fail(function(){
                fail();
            });
        }
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