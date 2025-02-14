window.modalHandlers['sposta_seduta'] = {
    btnSalva:function(element){
        const _data=this._data(element);
        const modal = element.closest('.modal');
        modal.querySelectorAll('[name]').forEach(named=>{_data[named.name]=named.value;});
        $.post('post/save.php',_data).done(function(){ 
            refresh({data:_data.data,id_terapista:_data.id_terapista});
        }).fail(function(){fail()});
    },
    btnPresente:function(element,id_terapista,data){
        const _data=this._data(element);
        _data['stato_prenotazione']='Conclusa';
        $.post('post/save.php',_data).done(function(){ 
            refresh({data:data,id_terapista:id_terapista});
        }).fail(function(){fail()});
    },
    btnAssente:function(element,id_terapista,data){
        const _data=this._data(element);
        _data['stato_prenotazione']='Assente';
        $.post('post/save.php',_data).done(function(){ 
            refresh({data:data,id_terapista:id_terapista});
        }).fail(function(){fail()});
    },
    change(element){
        closeAllModal();
        modal_component('sbarra', 'sposta_seduta', this._data(element));
    },
    _data(element){
        const { idSeduta } = element.dataset;
        let _data = { 
            table:'percorsi_terapeutici_sedute_prenotate',
            id:idSeduta
        };
        return _data;
    }
};
