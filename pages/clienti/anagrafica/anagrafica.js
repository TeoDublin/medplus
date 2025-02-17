

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
        trattamenti(id);
    }
    else if(element.classList.contains('success2')){
        percorsoCorso(id);
    }
    else if(element.classList.contains('success3')){
        pendenze(id);
    }
    else if(element.classList.contains('success4')){
        percorsoFatture(id);
    }
    else{
        add(id);
    }
}
function trattamenti(id){
    modal_component('percorsi','percorsi',{id_cliente:id});
}
function percorsoCorso(id){
    modal_component('percorsi_corsi','percorsi_corsi',{id_cliente:id});
}
function pendenze(id){
    modal_component('percorsi_pendenze','percorsi_pendenze',{id_cliente:id});
}
function percorsoFatture(id){
    modal_component('percorsi_fatture','percorsi_fatture',{id_cliente:id});
}
function add(id){
    modal_component('add_cliente','add_cliente',{id_cliente:id});
}
document.addEventListener('DOMContentLoaded',function(){
    search_table({
        table:'clienti',
        orderby:'nominativo ASC',
        cols:['id','nominativo','telefono','email'],
        actions:{ Trattamenti:'success', Corsi:'success2', Pendenze:'success3', Pagamenti:'success4' }
    });
});