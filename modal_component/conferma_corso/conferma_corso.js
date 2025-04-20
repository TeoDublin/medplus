window.modalHandlers['conferma_corso']={
    btnSalva:function(element){
        let _data = {table:'conferma_corso'};
        const mnodal = element.closest('.modal');
        mnodal.querySelectorAll('[name]').forEach(element=>{ _data[element.name]=element.value;});
        $.post('post/save.php',_data).done(function(){ success_and_refresh();}).fail(function(){fail()});
    },
    btnPresenza:function(e){
        e.dataset['prezzo']=e.closest('.modal').querySelector('#prezzo').value;
        $.post('post/conferma_corso_presenza.php',e.dataset).done(()=>{
            success_and_refresh();
        }).fail(()=>{fail()});
    },
    btnSospensione:function(e){
        $.post('post/conferma_corso_sostensione.php',e.dataset).done(()=>{
            success_and_refresh();
        }).fail(()=>{fail()});
    },
    btnRipristina:function(e){
        $.post('post/conferma_corso_ripristina.php',e.dataset).done(()=>{
            success_and_refresh();
        }).fail(()=>{fail()});
    }
} 
