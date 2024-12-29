window.modalHandlers['sbarra'] = {
    btnSalva:function(){
        let _data = {table:'planning_motivi'};
        document.querySelector('#div_planning').querySelectorAll('[name]').forEach(element=>{
            _data[element.name]=element.value;
        });
        $.post('post/save.php', _data)
        .done(function() { success_and_refresh(); })
        .fail(function() { fail(); });
    },
    btnElimina:function(id){
        $.post('post/delete.php',{table:'planning_motivi',id:id}).done(function(){success_and_refresh()}).fail(function(){fail()});
    }
};
