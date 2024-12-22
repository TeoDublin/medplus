

function delClick(element){
    if(confirm('Sicuro di voler Eliminare?')){
        $.post("post/delete.php?skip_cookie=true&table=clienti&id=" + element.closest('tr').getAttribute('rowId')).done(success_and_refresh).fail(fail);
    }
};
function searchClick(){
    window.location.href=window.location.href+"?search="+document.querySelector('.input-search').value;
}
function editClick(element){
    if(!element.classList.contains('warning')){
        modal_component('trattamenti','trattamenti',{id_cliente:element.closest('tr').getAttribute('rowid')});
    }
}