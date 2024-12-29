window.modalHandlers['percorsi'] = {
    btnPercorsoClick: function () {
        modal_component('percorso_terapeutico','percorso_terapeutico',{'id_cliente':document.querySelector('#id_cliente').value});
    },
    aggiungiSeduteClick : function (element,tipo_trattamento){
        const modal = element.closest('.modal');
        modal_component('sedute','sedute',{
            'id_cliente':modal.querySelector('#id_cliente').value,
            'id_percorso':element.closest('[name=row_percorso]').querySelector('[name=id_percorso]').value,
            'tipo_trattamento':tipo_trattamento
        });
    },
    aggiungiEnter : function (element){
        element.closest('[name=row_percorso]').removeAttribute('data-bs-toggle');
    },
    aggiungiLeave: function (element){
        element.closest('[name=row_percorso]').setAttribute('data-bs-toggle','collapse');
    },
    prenotaSeduteClick: function (element,id_seduta,id_cliente){
        modal_component('prenota_seduta','prenota_seduta',{
            'id_seduta':element.closest('[name=row_percorso]').querySelector('[name=id_seduta]').value,
            id_seduta:id_seduta,
            id_cliente:id_cliente
        });
    },
    prenotaEnter: function (element){
        element.closest('[name=row_percorso]').removeAttribute('data-bs-toggle');
    },
    prenotaLeave: function (element){
        element.closest('[name=row_percorso]').setAttribute('data-bs-toggle','collapse');
    },
    editClick: function (element){
        const modal = element.closest('.modal');
        modal_component('percorso_terapeutico','percorso_terapeutico',{
            'id_cliente':modal.querySelector('#id_cliente').value,
            'id':element.closest('[name=row_percorso]').querySelector('[name=id_percorso]').value
        });
    },
    editEnter: function (element){
        element.closest('[name=row_percorso]').removeAttribute('data-bs-toggle');
    },
    editLeave: function (element){
        element.closest('[name=row_percorso]').setAttribute('data-bs-toggle','collapse');
    },
    deleteClick: function (element){
        if(confirm('sicuro di voler eliminare ?')){
            $.post('post/delete.php',{
                id:element.closest('[name=row_percorso]').querySelector('[name=id_percorso]').value,
                table:'percorsi'
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
    deleteSedutaPrenotata: function (element,id){
        if(confirm('sicuro di voler eliminare ?')){
            $.post('post/delete.php',{table:'sedute_prenotate',id:id}).done(()=>{
                const id_cliente = element.closest('.modal').querySelector('#id_cliente').value;
                reload_modal_component('percorsi','percorsi',{'id_cliente':id_cliente});
            }).fail(function(){fail()});
        }
    },
    enterSedutaPrenotata: function (element){
        element.closest('div.flex-row').classList.add('bg-danger');
    },
    leaveSedutaPrenotata: function (element){
        element.closest('div.flex-row').classList.remove('bg-danger');
    },
    changeStatoPrenotazione: function (element,id){
        $.post('post/save.php',{
            table:'sedute_prenotate',
            stato_prenotazione:element.value,
            id:id
        }).done(()=>{
            reload_modal_component('percorsi','percorsi',{
                'id_cliente':element.closest('.modal').querySelector('#id_cliente').value
            });
        }).fail(()=>fail());
    }
}