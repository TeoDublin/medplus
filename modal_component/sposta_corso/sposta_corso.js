window.modalHandlers['sposta_corso'] = {
    btnSalva:function(element){
        const _data=this._data(element);
        $.post('post/sposta_corso_save.php',_data).done(function(){ 
            refresh({data:_data.data,id_terapista:_data.id_terapista});
        }).fail(function(){fail()});
    },
    btnDelete:function(element){
        let _data=this._data(element);
        _data['delete']=true;
        $.post('post/sposta_corso_save.php',_data).done(function(){ 
            refresh({data:_data.data,id_terapista:_data.id_terapista});
        }).fail(function(){fail()});
    },
    change(element){
        closeAllModal();
        modal_component('sbarra', 'sposta_corso', this._data(element));
    },
    _data(element){
        const modal = element.closest('.modal');
        const { idCorso } = element.dataset;
        let _data = { 
            table:'corsi_planning',
            id:idCorso
        };
        
        modal.querySelectorAll('[name]').forEach(named=>{_data[named.name]=named.value;});
        return _data;
    }
};
