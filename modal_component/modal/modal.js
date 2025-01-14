window.modalHandlers['modal'] = {
    save:function(element,table){
        modal = element.closest('.modal');
        let _data = {table:table}; 
        modal.querySelectorAll('[name]').forEach(named=>{
            _data[named.name]=named.value;
        });
        $.post('post/save.php',_data).done(function(){success_and_refresh();}).fail(function(){fail()});
    }
}