window.modalHandlers['corsi_elenco']={
    btnSalva:function(element,table){
        let _data = {table:table};
        const mnodal = element.closest('.modal');
        mnodal.querySelectorAll('[name]').forEach(element=>{ _data[element.name]=element.value;});
        $.post('post/save.php',_data).done(function(){ success_and_refresh();}).fail(function(){fail()});
    },
    aggiungiGiorno(element){
        $.post('post/aggiungi_giorno.php').done(response =>{
            let div = document.createElement('div');
            div.classList = 'd-flex flex-row w-100 mt-2 giorno_row';
            div.innerHTML = response;
            element.closest('.modal').querySelector('#table-body').append(div);
        });
    },
    delEnter(element){
        element.closest('div.giorno_row').classList.add('warning');
    },
    delLeave(element){
        element.closest('div.giorno_row').classList.remove('warning');
    },
    delClick(element){
        element.closest('div.giorno_row').remove();
    },
} 
