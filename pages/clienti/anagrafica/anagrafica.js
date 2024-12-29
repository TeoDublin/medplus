

function delClick(id){
    if(confirm('Sicuro di voler Eliminare?')){
        $.post("post/delete.php",{table:'clienti',id:id}).done(success_and_refresh).fail(fail);
    }
};
function searchClick(){
    window.location.href=window.location.href+"?search="+document.querySelector('.input-search').value;
}
function editClick(element,id){
    if(element.classList.contains('warning')){
        delClick(id);
    }
    else if(element.classList.contains('success')){
        addPercorso(id);
    }
    else if(element.classList.contains('success2')){
        addPercorsoPagamento(id);
    }
    else{
        add(id);
    }
}
function addPercorso(id){
    modal_component('percorsi','percorsi',{id_cliente:id});
}
function addPercorsoPagamento(id){
    modal_component('percorsi_pagamenti','percorsi_pagamenti',{id_cliente:id});
}
function add(id){
    let _data = { table:'clienti', header:'Cliente' };
    if(id){_data["id"]=id;}
    modal_component('modal','modal',_data);
}
document.addEventListener('DOMContentLoaded',function(){
    search(false);
});
function search(text){
    let _data={
        table:'clienti',
        cols:['id','nominativo','telefono','notizie_cliniche','email'],
        actions:{Percorsi:'success',Pagamenti:'success2'}
    };
    if(text)_data['search']={key:'nominativo',value:text};
    component('search_table',_data);
}