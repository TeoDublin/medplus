window.modalHandlers['example']={
    btnSalva:function(element){
        let _data = {table:'example'};
        const mnodal = element.closest('.modal');
        mnodal.querySelectorAll('[name]').forEach(element=>{ _data[element.name]=element.value;});
        $.post('post/save.php',_data).done(function(){ success_and_refresh();}).fail(function(){fail()});
    }
} 
