window.modalHandlers['classi'] = {
    click:function(e){
        if(e.classList.contains('payed')){
            alert('già Fatturato');
        }
        else{
            modal_component('conferma_corso','conferma_corso',e.dataset);
        }
    }
}