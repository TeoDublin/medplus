window.modalHandlers['trattamenti_elenco']={
    selectColor:function(element){
        const modal = element.closest('.modal');
        modal.querySelector('[name=id_colore]').value = element.dataset.idColore;
        modal.querySelectorAll('.trattamento-colore').forEach(button => {
            button.classList.remove('selected');
        });
        element.classList.add('selected');
    },
    btnSalva:function(element,table){
        let _data = {table:table};
        const mnodal = element.closest('.modal');
        mnodal.querySelectorAll('[name]').forEach(element=>{ _data[element.name]=element.value;});
        $.post('post/trattamenti_save.php',_data).done(function(){ success_and_refresh();}).fail(function(){fail()});
    }
} 
