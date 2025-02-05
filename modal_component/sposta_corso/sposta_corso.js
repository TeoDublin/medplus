window.modalHandlers['sposta_corso'] = {
    btnSalva:function(element){
        $.post('post/save.php',this._data(element)).done(function(){ 
            refresh({data:_data.data,id_terapista:_data.id_terapista});
        }).fail(function(){fail()});
    },
    change(element){
        closeAllModal();
        modal_component('sbarra', 'sposta_corso', this._data(element));
    },
    _data(element){
        const modal = element.closest('.modal');
        const { idCorso, idTerapista } = element.dataset;
        let _data = { 
            table:'corsi_planning',
            id:idCorso,
            id_terapista:idTerapista,
        };
        
        modal.querySelectorAll('[name]').forEach(named=>{_data[named.name]=named.value;});
        _data['row']=_data['row_inizio'];
        return _data;
    }
};
