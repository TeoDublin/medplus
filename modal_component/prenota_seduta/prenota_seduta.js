window.modalHandlers['prenota_seduta'] = {
    dayClick:function(element,day,id_cliente){
        const modal = element.closest('.modal');
        let _data={
            id_terapista:modal.querySelector('#prenota_terapista').value,
            data:modal.querySelector('#prenota_year').value+'-'+modal.querySelector('#prenota_month').value+'-'+day,
            id_seduta: modal.querySelector('#id_seduta').value,
            id_cliente: id_cliente
        }
        modal_component('prenota_seduta_planning','prenota_seduta_planning',_data);
    },
    dateChange:function(element){
        const modal = element.closest('.modal');
        modal_component('prenota_seduta','prenota_seduta',{
            month: modal.querySelector('#prenota_month').value, 
            year: modal.querySelector('#prenota_year').value
        });
    }
}