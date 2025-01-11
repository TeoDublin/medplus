window.modalHandlers['corsi_elenco']={
    btnSalva:function(element,table){
        let _data = {table:table};
        const mnodal = element.closest('.modal');
        mnodal.querySelectorAll('[name]').forEach(element=>{ _data[element.name]=element.value;});
        $.post('post/save.php',_data).done(function(){ success_and_refresh();}).fail(function(){fail()});
    }
} 
