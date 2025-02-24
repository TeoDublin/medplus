window.modalHandlers['percorsi'] = {
    btnPercorsoClick: function (id_cliente) {
        modal_component('percorso_combo','percorso_combo',{id_cliente:id_cliente});
    },
    btncolloquioClick: function (id_cliente) {
        modal_component('prenota_colloquio','prenota_colloquio',{id_cliente:id_cliente});
    },
    prenotaSeduteClick: function (id_seduta,id_cliente,id_percorso){
        modal_component('prenota_planning','prenota_planning',{
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
    changeStatoColloquio:function(element,id){
        $.post('post/save.php',{
            table:'colloquio_planning',
            stato_prenotazione:element.value,
            id:id
        }).done(()=>{
            reload_modal_component('percorsi','percorsi',{
                'id_cliente':element.closest('.modal').querySelector('#id_cliente').value
            });
        }).fail(()=>fail());
    },
    deleteColloquio:function(element,id){
        $.post('post/delete.php',{table:'colloquio_planning',id:id}).done(()=>{
            reload_modal_component('percorsi','percorsi',{
                'id_cliente':element.closest('.modal').querySelector('#id_cliente').value
            });
        }).fail(()=>fail());
    },
    enterColloquio:function(element){
        element.closest('div.flex-row').classList.add('bg-danger');
    },
    leaveColloquio:function(element){
        element.closest('div.flex-row').classList.remove('bg-danger');
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
    },
    acronimoEnter:function(element) {
        const popover = bootstrap.Popover.getOrCreateInstance(element, {
            title: 'Trattamenti',
            content: element.getAttribute('data-bs-content'),
            placement: 'top',
            trigger: 'manual'
        });
        popover.show();
    },
    acronimoLeave:function(element) {
        const popover = bootstrap.Popover.getInstance(element);
        if (popover) {
            popover.hide();
        }
    },
    check:function(element){
        const modal = element.closest('.modal');
        let btn = modal.querySelector('#del-sedute');
        if(element.classList.contains('checked')){
            element.classList.remove('checked');
        }
        else element.classList.add('checked');
        if(modal.querySelectorAll('.checked').length >0){
            if(btn.classList.contains('d-none')){
                btn.classList.remove('d-none');
            }
        }
        else btn.classList.add('d-none');
    },
    deleteSeduteClick:function(element,id_cliente){
        const modal = element.closest('.modal');
        const checked = modal.querySelectorAll('.checked');
        let ids = [];
        if(checked.length >0){
            checked.forEach(check=>{
                ids.push(check.closest('.accordion-button').querySelector('[name=id_seduta]').value);
            });
            $.post('post/delete_sedute.php',{ids:ids}).done(()=>{
                reload_modal_component('percorsi','percorsi',{id_cliente:id_cliente});
            }).fail(()=>{
                fail();
            });
        }
        else alert("Seleziona qualcosa");
    },
    addSeduteClick:function(id_cliente,id_percorso,id_combo){
        modal_component('add_sedute','add_sedute',{id_cliente:id_cliente,id_percorso:id_percorso,id_combo:id_combo});
    }
}