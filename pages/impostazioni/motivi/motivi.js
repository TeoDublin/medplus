
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
        $.post("post/delete.php",{id:id}).done(success_and_refresh).fail(fail);
    }
};
function add(id){
    let _data = { table:'motivi', header:'Motivi', cols:3 };
    if(id){_data["id"]=id;}
    modal_component('modal','modal',_data);
}