document.addEventListener("DOMContentLoaded", () => {
    const actions = {
        btnSearch: document.querySelector('.btn-search'),
        btnInsert: document.querySelector('.btn-insert'),
        rowEdit: document.querySelectorAll('.table-row'),
        delList: document.querySelectorAll('.action-Elimina'),
        iconDel: document.querySelectorAll('.action-Elimina'),
        searchInput: document.querySelector('.input-search'),
        listen: function(){
            const modal=function(id){
                let _data={ 'name':'terapisti','skip_cookie':true,'id':id };
                $.post('component.php', _data, function(data) {
                    document.querySelector('#modal-body').innerHTML = data;
                    const modalElement = document.getElementById('modal');
                    const modal = new bootstrap.Modal(modalElement);
                    modalElement.querySelector('.modal-title').textContent = 'Terapistia';
                    modalElement.querySelector('.modal-dialog').classList.add('modal-md');
                    const addButton = modalElement.querySelector('.btn-add');
                    addButton.replaceWith(addButton.cloneNode(true));
                    let _data = {"table":"terapisti"};
                    modalElement.querySelector('.btn-add').addEventListener('click', () => {
                        modalElement.querySelectorAll('[name]').forEach((modalInput)=>{ _data[modalInput.name] = modalInput.value; });
                        modal.hide();
                        $.post('post/save.php',_data).done(success_and_refresh).fail(fail);
                    });
                    modal.show();
                })
                .catch(error => { console.error('Error fetching customer picker:', error);});
            };
            const delClick = function() {
                confirm('Sicuro di voler Eliminare?') &&
                    $.post("post/delete.php?skip_cookie=true&table=terapisti&id=" + this.closest('tr').getAttribute('rowId'))
                    .done(success_and_refresh)
                    .fail(fail);
            };
            const insertClick = () => modal(false);
            const editClick = event => modal(event.currentTarget.closest('tr').getAttribute('rowId'));
            const hoverIconDel = event => hoverIconWarning(event.currentTarget);
            const btnSearchClick = () => window.location.href=window.location.href+"?skip_cookie=true&search="+document.querySelector('.input-search').value;
            this.searchInput.addEventListener('keydown', event => event.key === 'Enter' && btnSearchClick());
            this.btnInsert.addEventListener('click', insertClick);
            this.rowEdit.forEach(function(item){ item.addEventListener('click', editClick);});
            this.delList.forEach(function(item){ item.addEventListener('click', delClick); });
            this.iconDel.forEach(function(item){ item.addEventListener('mouseenter', hoverIconDel); });
            this.btnSearch.addEventListener('click',btnSearchClick);
        },
    };
    actions.listen();
});