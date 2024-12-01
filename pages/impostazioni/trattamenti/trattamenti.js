

function delClick(element){
    if(confirm('Sicuro di voler Eliminare?')){
        $.post("post/delete.php?skip_cookie=true&table=trattamenti&id=" + element.closest('tr').getAttribute('rowId')).done(success_and_refresh).fail(fail);
    }
};
function searchClick(){
    window.location.href=window.location.href+"?search="+document.querySelector('.input-search').value;
}
function editClick(element){
    if(!element.classList.contains('warning')){
        modal(element.getAttribute('rowId'));
    }
}

function modal(id){
    let _data={ 'name':'trattamenti','skip_cookie':true,'id':id };
    $.post('component.php', _data, function(data) {
        document.querySelector('#modal-body').innerHTML = data;
        const modalElement = document.getElementById('modal');
        const modal = new bootstrap.Modal(modalElement);
        modalElement.querySelector('.modal-title').textContent = 'Trattamento';
        modalElement.querySelector('.modal-dialog').classList.add('modal-md');
        const addButton = modalElement.querySelector('.btn-add');
        addButton.replaceWith(addButton.cloneNode(true));
        let _data = {"table":"trattamenti"};
        modalElement.querySelector('.btn-add').addEventListener('click', () => {
            modalElement.querySelectorAll('[name]').forEach((modalInput)=>{ _data[modalInput.name] = modalInput.value; });
            modal.hide();
            $.post('post/save.php',_data).done(success_and_refresh).fail(fail);
        });
        modal.show();
    })
    .catch(error => { console.error('Error fetching customer picker:', error);});
}