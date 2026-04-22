
window.modalHandlers['pagamenti_child'] = {

    btnSalva:function(element){

        let $fattura_aruba = document.querySelector('input[name=fattura_aruba]');

        if ($fattura_aruba) {
            if ($fattura_aruba.value === '') {
                alert('Fattura Aruba è obbligatorio');
                $fattura_aruba.classList.add('bg-warning');
                return;
            }
        }
        const payloadData = payload();

        let _data = {
            payload : payloadData,
        };

        const modal = element.closest('.modal');
        
        modal.querySelectorAll('[name]').forEach( (element) =>{ 
            _data[element.name]=element.value;
        });

        $.post(
            'modal_component/pagamenti_child/post/pagamenti_child.php',
            _data
        )
        .done(function(){ 
            reload_modal_component(
                'percorsi_pendenze',
                'percorsi_pendenze',
                payloadData
            );
        })
        .fail(function(){
            fail()
        });
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
