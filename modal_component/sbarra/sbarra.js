window.modalHandlers['sbarra'] = {
    btnSalva:function(element){
        const modal = element.closest('.modal');
        let _data = {table:'planning_motivi'};
        modal.querySelectorAll('[name]').forEach(named=>{
            _data[named.name]=named.value;
        });
        $.post('post/save.php', _data)
        .done(function() { success_and_refresh(); })
        .fail(function() { fail(); });
    },
    btnElimina:function(id){
        $.post('post/delete.php',{table:'planning_motivi',id:id}).done(function(){success_and_refresh()}).fail(function(){fail()});
    }
};
