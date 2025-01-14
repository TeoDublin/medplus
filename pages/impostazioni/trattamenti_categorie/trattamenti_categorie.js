
function searchClick(){
    window.location.href=window.location.href+"?search="+document.querySelector('.input-search').value;
}
function editClick(element,id){
    if(element.classList.contains('warning')){
        delClick(id);
    }
    else{
        add(id);
    }
}
function delClick(id){
    if(confirm('Sicuro di voler Eliminare?')){
        $.post("post/delete.php",{table:'trattamenti_categorie',id:id}).done(success_and_refresh).fail(fail);
    }
};
function add(id){
    let _data = { table:'trattamenti_categorie', header:'Categorie Trattamenti' };
    if(id){_data["id"]=id;}
    modal_component('modal','modal',_data);
}
document.addEventListener('DOMContentLoaded',function(){
    search_table({table:'trattamenti_categorie'});
});