window.modalHandlers['percorso_terapeutico'] = {
    btnSalva:function(modal_id){
        let _data = {table:'percorsi'};
        let div_modal = document.querySelector('#'+modal_id);
        div_modal.querySelectorAll('[name]').forEach(element=>{
            _data[element.name]=element.value;
        });
        $.post('post/percorso_terapeutico.php',_data).done(function(){
            reload_modal_component('percorsi','percorsi',_data);
        }).fail(function(){fail()});
    },
    changeTipoPercorso:function(element){
        modal = element.closest('.modal');
        console.log(element.value);
        switch (element.value) {
            case 'Mensile':
                modal.querySelectorAll('.mensile').forEach(per_seduta=>{
                    per_seduta.removeAttribute('hidden');
                });
                break;
            case 'Per Sedute':
                modal.querySelectorAll('.mensile').forEach(per_seduta=>{
                    per_seduta.setAttribute('hidden','');
                });
                break;
        }
    }
}