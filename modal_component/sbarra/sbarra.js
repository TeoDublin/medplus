function btnSalva(){
    let _data = {table:'planning_motivi'};
    document.querySelector('#div_panning').querySelectorAll('[name]').forEach(element=>{
        _data[element.name]=element.value;
    });
    $.post('post/save.php', _data)
    .done(function() { success_and_refresh(); })
    .fail(function() { fail(); });

}