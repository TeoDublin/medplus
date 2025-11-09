window.modalHandlers['indirizzato_a']={
    btnSalva:function(element){
        const save = element.closest('.modal').querySelector('.save');
        let _data = save.dataset;
        _data['table'] = 'indirizzato_a';
        save.querySelectorAll('[name]').forEach(element=>{ _data[element.name]=element.value;});
        $.post('post/save.php',_data).done(function(){ 
            success_and_refresh();
        }).fail(function(){
            fail()
        });
    }
} 
