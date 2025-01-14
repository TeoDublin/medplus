window.modalHandlers['percorsi'] = {
    btnPercorsoClick: function () {
        modal_component('percorso_terapeutico','percorso_terapeutico',{'id_cliente':document.querySelector('#id_cliente').value});
    },
    prenotaSeduteClick: function (element,id_seduta,id_cliente,id_percorso){
        modal_component('prenota_seduta','prenota_seduta',{
            id_seduta:id_seduta,
            id_cliente:id_cliente,
            id_percorso:id_percorso
        });
    },
    prenotaEnter: function (element){
        element.closest('[name=row_percorso]').removeAttribute('data-bs-toggle');
    },
    prenotaLeave: function (element){
        element.closest('[name=row_percorso]').setAttribute('data-bs-toggle','collapse');
    },
    deleteClick: function (element){
        if(confirm('sicuro di voler eliminare ?')){
            $.post('post/delete.php',{
                id:element.closest('[name=row_percorso]').querySelector('[name=id_percorso]').value,
                table:'percorsi_terapeutici'
            }).done(function(){
                const id_cliente = element.closest('.modal').querySelector('#id_cliente').value;
                reload_modal_component('percorsi','percorsi',{'id_cliente':id_cliente});
            }).fail(function(){fail();});
        }
    },
    deleteEnter: function (element){
        let row_percorso=element.closest('[name=row_percorso]');
        row_percorso.removeAttribute('data-bs-toggle');
        row_percorso.classList.add('warning');
    },
    deleteLeave: function (element){
        let row_percorso=element.closest('[name=row_percorso]');
        row_percorso.setAttribute('data-bs-toggle','collapse');
        row_percorso.classList.remove('warning');
    },
    deleteSedutaPrenotata: function (element,id,id_percorso,id_seduta){
        if(confirm('sicuro di voler eliminare ?')){
            $.post('post/delete.php',{table:'percorsi_terapeutici_sedute_prenotate',id:id}).done(()=>{
                const id_cliente = element.closest('.modal').querySelector('#id_cliente').value;
                reload_modal_component('percorsi','percorsi',{id_cliente:id_cliente,id_percorso:id_percorso,id_seduta:id_seduta});
            }).fail(function(){fail()});
        }
    },
    enterSedutaPrenotata: function (element){
        element.closest('div.flex-row').classList.add('bg-danger');
    },
    leaveSedutaPrenotata: function (element){
        element.closest('div.flex-row').classList.remove('bg-danger');
    },
    changeStatoPrenotazione: function (element,id,id_seduta){
        $.post('post/save.php',{
            table:'percorsi_terapeutici_sedute_prenotate',
            stato_prenotazione:element.value,
            id:id
        }).done(()=>{
            reload_modal_component('percorsi','percorsi',{
                'id_cliente':element.closest('.modal').querySelector('#id_cliente').value,
                id_seduta:id_seduta
            });
        }).fail(()=>fail());
    },
    noteEnter:function(element) {
        const popover = bootstrap.Popover.getOrCreateInstance(element, {
            title: 'Note',
            content: element.getAttribute('data-bs-content'),
            placement: 'top',
            trigger: 'manual'
        });
        popover.show();
    },
    noteLeave:function(element) {
        const popover = bootstrap.Popover.getInstance(element);
        if (popover) {
            popover.hide();
        }
    }
}