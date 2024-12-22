function dayClick(element,day){
    const modal = element.closest('.modal');
    const _data={
        id_terapista:modal.querySelector('#prenota_terapista').value,
        data:modal.querySelector('#prenota_year').value+'-'+modal.querySelector('#prenota_month').value+'-'+day,
        id_seduta: modal.querySelector('#id_seduta').value,
        id_cliente: modal.querySelector('#id_cliente').value
    }
    modal_component('prenota_seduta_planning','prenota_seduta_planning',_data);
}
function dateChange(element){
    const modal = element.closest('.modal');
    modal_component('prenota_seduta','prenota_seduta',{
        month: modal.querySelector('#prenota_month').value, 
        year: modal.querySelector('#prenota_year').value
    });
}