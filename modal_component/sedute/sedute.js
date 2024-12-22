function btnSalva(element){
    let _data = {};
    const mnodal = element.closest('.modal');
    mnodal.querySelectorAll('[name]').forEach(element=>{ _data[element.name]=element.value;});
    $.post('post/sedute.php',_data).done(function(){
        closeAllModal();
        modal_component('percorsi','percorsi',_data);
        success();
    }).fail(function(){fail()});
}
function changeTrattamento(element){
    const modal_component=element.closest('.modal-content');
    const select=modal_component.querySelector('#id_trattamento');
    const selected=select.querySelector('[value="'+select.value+'"]');
    const tipo_trattamento=selected.getAttribute('tipo');
    const sedute=modal_component.querySelector('#div_sedute');
    const selected_prezzo=selected.getAttribute('prezzo');
    const prezzo=modal_component.querySelector('#div_prezzo');
    const prezzo_a_seduta=modal_component.querySelector('#div_prezzo_a_seduta');
    const prezzo_tabellare=modal_component.querySelector('#div_prezzo_tabellare');
    const prezzo_tabellare_a_seduta=modal_component.querySelector('#div_prezzo_tabellare_a_seduta');
    
    switch (tipo_trattamento) {
        case 'Mensile':
            prezzo.removeAttribute('hidden');
            prezzo.querySelector('input').value = selected_prezzo;
            prezzo_tabellare.removeAttribute('hidden');
            prezzo_tabellare.querySelector('input').value = selected_prezzo;
            sedute.setAttribute('hidden','');
            prezzo_tabellare_a_seduta.setAttribute('hidden','');
            prezzo_a_seduta.setAttribute('hidden','');
            break;
        case 'Per Seduta':
            sedute.removeAttribute('hidden');
            prezzo.removeAttribute('hidden');
            prezzo.querySelector('input').value = selected_prezzo*sedute.querySelector('input').value;
            prezzo_a_seduta.removeAttribute('hidden');
            prezzo_a_seduta.querySelector('input').value = selected_prezzo;
            prezzo_tabellare.removeAttribute('hidden');
            prezzo_tabellare.querySelector('input').value = selected_prezzo*sedute.querySelector('input').value;
            prezzo_tabellare_a_seduta.removeAttribute('hidden');
            prezzo_tabellare_a_seduta.querySelector('input').value = selected_prezzo;
            break;
        default:
            prezzo.setAttribute('hidden','');
            prezzo_a_seduta.setAttribute('hidden','');
            prezzo_tabellare.setAttribute('hidden','');
            prezzo_tabellare_a_seduta.setAttribute('hidden','');
            sedute.setAttribute('hidden','');
            break;
    }
}
function changeSedute(element){
    const modal_component=element.closest('.modal-content');
    const sedute=modal_component.querySelector('#sedute');
    const prezzo=modal_component.querySelector('#prezzo');
    const prezzo_a_seduta=modal_component.querySelector('#prezzo_a_seduta');
    const prezzo_tabellare=modal_component.querySelector('#prezzo_tabellare');
    const prezzo_tabellare_a_seduta=modal_component.querySelector('#prezzo_tabellare_a_seduta');

    prezzo_tabellare.value = prezzo_tabellare_a_seduta.value*sedute.value;
    prezzo.value = prezzo_a_seduta.value*sedute.value;
}
function changePrezzoASeduta(element){
    const modal_component=element.closest('.modal-content');
    const sedute=modal_component.querySelector('#sedute');
    const prezzo=modal_component.querySelector('#prezzo');
    const prezzo_a_seduta=modal_component.querySelector('#prezzo_a_seduta');
    prezzo.value = prezzo_a_seduta.value * sedute.value;
}
function changePrezzo(element){
    const modal_component=element.closest('.modal-content');
    const sedute=modal_component.querySelector('#sedute');
    const prezzo=modal_component.querySelector('#prezzo');
    const prezzo_a_seduta=modal_component.querySelector('#prezzo_a_seduta');
    prezzo_a_seduta.value = prezzo.value / sedute.value;
}