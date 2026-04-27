

function delClick(id){

    if(confirm('Sicuro di voler Eliminare?')){

        $.post(
            'post/delete.php',
            {
                table : 'terapisti',
                id : id
            }
        )
        .done((reponse) =>{
            success_and_refresh();
        })
        .fail((response) => {
            fail();
        });
    }
}

function editClick(element,id){

    if(element.classList.contains('warning')){
        delClick(id);
    }
    else{
        add(id);
    }
}

function add(id){
    modal_component('terapisti_percentuali','terapisti_percentuali',{id:id});
}

document.addEventListener('DOMContentLoaded',function(){
    search_table({
        table:'view_terapisti_percentuali',
        orderby:'terapista ASC',
        cols:['id','terapista','profilo','percentuali_trattamenti','percentuali_corsi'],
        actions:{ }
    });
});