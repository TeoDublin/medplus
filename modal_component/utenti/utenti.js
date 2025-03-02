window.modalHandlers['utenti']={
    btnSalva:function(element){
        let _data = {table:'utenti'};
        const mnodal = element.closest('.modal');
        mnodal.querySelectorAll('[name]').forEach(element=>{ _data[element.name]=element.value;});
        $.post('post/utenti.php',_data).done(function(){ success_and_refresh();}).fail(function(){fail()});
    }
} 
