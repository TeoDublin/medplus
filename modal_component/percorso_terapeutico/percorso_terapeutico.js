window.modalHandlers['percorso_terapeutico']={
    btnSalva:function(element,caller){
        let _data = {};
        const mnodal = element.closest('.modal');
        mnodal.querySelectorAll('[name]').forEach(element=>{ _data[element.name]=element.value;});
        switch (caller) {
            case 'percorsi_pendenze':
                $.post('post/percorsi_pendenze.php',_data).done(function(){
                    reload_modal_component('percorsi_pendenze','percorsi_pendenze',_data);
                }).fail(function(){fail()});     
                break;
        
            default:
                $.post('post/percorso_terapeutico.php',_data).done(function(){
                    reload_modal_component('percorsi','percorsi',_data);
                }).fail(function(){fail()});                
                break;
        }
    },
    changeTrattamento:function(element){
        const modal_component=element.closest('.modal-content');
        const select=modal_component.querySelector('#id_trattamento');
        const selected=select.querySelector('[value="'+select.value+'"]');
        const sedute=modal_component.querySelector('#div_sedute');
        const selected_prezzo=selected.getAttribute('prezzo');
        const prezzo=modal_component.querySelector('#div_prezzo');
        const prezzo_a_seduta=modal_component.querySelector('#div_prezzo_a_seduta');
        const prezzo_tabellare=modal_component.querySelector('#div_prezzo_tabellare');
        const prezzo_tabellare_a_seduta=modal_component.querySelector('#div_prezzo_tabellare_a_seduta');
        
        sedute.removeAttribute('hidden');
        sedute.classList.remove('mensile');
        prezzo.removeAttribute('hidden');
        prezzo.querySelector('input').value = selected_prezzo*sedute.querySelector('input').value;
        prezzo_a_seduta.removeAttribute('hidden');
        prezzo_a_seduta.querySelector('input').value = selected_prezzo;
        prezzo_tabellare.removeAttribute('hidden');
        prezzo_tabellare.querySelector('input').value = selected_prezzo*sedute.querySelector('input').value;
        prezzo_tabellare_a_seduta.removeAttribute('hidden');
        prezzo_tabellare_a_seduta.querySelector('input').value = selected_prezzo;

    },
    changeSedute:function(element){
        const modal_component=element.closest('.modal-content');
        const sedute=modal_component.querySelector('#sedute');
        if(!sedute.closest('#div_sedute').classList.contains('mensile')){
            const prezzo=modal_component.querySelector('#prezzo');
            const prezzo_a_seduta=modal_component.querySelector('#prezzo_a_seduta');
            const prezzo_tabellare=modal_component.querySelector('#prezzo_tabellare');
            const prezzo_tabellare_a_seduta=modal_component.querySelector('#prezzo_tabellare_a_seduta');
        
            prezzo_tabellare.value = prezzo_tabellare_a_seduta.value*sedute.value;
            prezzo.value = prezzo_a_seduta.value*sedute.value;
        }
    },
    changePrezzoASeduta:function(element){
        const modal_component=element.closest('.modal-content');
        const sedute=modal_component.querySelector('#sedute');
        const prezzo=modal_component.querySelector('#prezzo');
        const prezzo_a_seduta=modal_component.querySelector('#prezzo_a_seduta');
        prezzo.value = prezzo_a_seduta.value * sedute.value;
    },
    changePrezzo:function(element){
        const modal_component=element.closest('.modal-content');
        const sedute=modal_component.querySelector('#sedute');
        const prezzo=modal_component.querySelector('#prezzo');
        const prezzo_a_seduta=modal_component.querySelector('#prezzo_a_seduta');
        prezzo_a_seduta.value = prezzo.value / sedute.value;
    }
} 
