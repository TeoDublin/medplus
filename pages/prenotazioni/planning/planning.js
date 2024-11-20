function openCalendar(event, element) {
    const rect = event.target.getBoundingClientRect();
    $.post('component.php', { name: 'calendar' })
        .done(data => {
            const content = document.createElement('div');
            content.innerHTML = data;
            document.querySelector('.page-content').appendChild(content);
            calendar.start('.date-target', rect.x, rect.y);
        })
        .fail(error => {
            console.error('Error fetching calendar:', error);
        });
}
function openCustomerPicker(element) {
    let _data={
        'name':'customer-picker',
        'skip_cookie':true,
        'row':element.closest('tr').getAttribute('row'),
        'data':document.querySelector('.date-target').value,
        'id_terapista':element.getAttribute('id_terapista'),
        'tab':'anagrafica'
    };
    $.post('page_component.php', _data, function(data) {
        document.querySelector('#modal-body').innerHTML = data;
        const modalElement = document.getElementById('modal');
        const modal = new bootstrap.Modal(modalElement);
        modalElement.querySelector('.modal-title').textContent = 'Planning';
        modalElement.querySelector('.modal-dialog').classList.add('modal-xl');
        const checkDelete = modalElement.querySelector('.btn-delete');
        if(checkDelete)checkDelete.remove();
        const deleteBtn = document.createElement('button');
        deleteBtn.textContent = 'ELIMINA';
        deleteBtn.className = 'btn btn-danger btn-delete';
        deleteBtn.addEventListener('click',()=>{
            $.post('post/first.php',{'skip_cookie':true,'select':'*','from':'planning','where':"`row`="+_data['row']+" and `data`='"+_data['data']+"' and `id_terapista`="+_data['id_terapista']})
            .done(result=>{
                const json_result=JSON.parse(result);
                if(json_result.id){
                    $.post('post/delete.php',{'skip_cookie':true,'id':json_result.id,'table':'planning'}).done(success_and_refresh);
                }
            })
        });
        modalElement.querySelector('.modal-footer').insertBefore(deleteBtn,modalElement.querySelector('.modal-footer').children[0]);
        const addButton = modalElement.querySelector('.btn-add');
        addButton.replaceWith(addButton.cloneNode(true));
        const newAddButton = modalElement.querySelector('.btn-add');
        modalElement.querySelector('.btn-add').addEventListener('click', () => {
            const _data = {
                skip_cookie:true,
                operation:'all',
                row:element.closest('tr').getAttribute('row'),
                data:document.querySelector('.date-target').value,
                ora:element.closest('tr').querySelector('.hour-target').value,
                id_terapista:element.getAttribute('id_terapista')
            };
            modalElement.querySelectorAll('[name]').forEach((modalInput)=>{ _data[modalInput.name] = modalInput.value; });
            modal.hide();
            $.post('post/planning.php',_data).done(success_and_refresh).fail(fail);
        });
        trattamenti.bind();
        append_scripts(modalElement);
        modal.show();
    })
    .catch(error => {
        console.error('Error fetching customer picker:', error);
    });
}
function noteClick(element) {
    document.querySelectorAll('.note-card').forEach(card => card.remove());
    const rect = element.getBoundingClientRect();
    const x = rect.x + window.scrollX;
    const y = rect.y + window.scrollY;
    const card = document.createElement('div');
    card.className = 'note-card card card-body text-center';
    const viewportWidth = window.innerWidth;
    card.style.top = `${y}px`;
    card.style.position = 'absolute';
    card.style.left = `${x}px`;
    card.style.left = (x + 300 > viewportWidth)? `${x - 230}px`:`${x}px`;
    card.style.top = `${y}px`;
    card.style.width = '300px';
    card.style.zIndex = '1000';
    const input = document.createElement('input');
    input.className='form-control'
    input.value = element.value || '';
    card.appendChild(input);

    const row = document.createElement('div');
    row.className = 'd-flex flex-row pt-2';
    const cancelButton = document.createElement('button');
    cancelButton.className = 'btn btn-secondary w-50 me-1';
    cancelButton.textContent = 'ANNULLA';
    cancelButton.addEventListener('click', () => card.remove());
    row.appendChild(cancelButton);

    const saveButton = document.createElement('button');
    saveButton.textContent = 'SALVA';
    saveButton.className = 'btn btn-primary w-50 ms-1';
    const save = () => {
        element.value = input.value;
        const _data = {
            skip_cookie: true,
            operation: input.value === '' ? 'clean_note' : 'note',
            note: input.value,
            row: element.closest('tr').getAttribute('row'),
            data: document.querySelector('.date-target').value,
            id_terapista: element.getAttribute('id_terapista')
        };
        $.post('post/planning.php', _data).done(success_and_refresh).fail(fail);
        card.remove();
    };
    saveButton.addEventListener('click', save);
    input.addEventListener('keydown', (event) => { if (event.key === 'Enter') save();});
    row.appendChild(saveButton);
    card.appendChild(row);
    document.body.appendChild(card);
}
function hourClick(element) {
    document.querySelectorAll('.note-card').forEach(card => card.remove());
    const rect = element.getBoundingClientRect();
    const x = rect.x + window.scrollX;
    const y = rect.y + window.scrollY;
    const card = document.createElement('div');
    card.className = 'note-card card card-body text-center';
    const viewportWidth = window.innerWidth;
    card.style.top = `${y}px`;
    card.style.position = 'absolute';
    card.style.left = `${x}px`;
    card.style.left = (x + 300 > viewportWidth)? `${x - 230}px`:`${x}px`;
    card.style.top = `${y}px`;
    card.style.width = '300px';
    card.style.zIndex = '1000';
    const input = document.createElement('input');
    input.className='form-control'
    input.value = element.value || '';
    card.appendChild(input);

    const row = document.createElement('div');
    row.className = 'd-flex flex-row pt-2';
    const cancelButton = document.createElement('button');
    cancelButton.className = 'btn btn-secondary w-50 me-1';
    cancelButton.textContent = 'ANNULLA';
    cancelButton.addEventListener('click', () => card.remove());
    row.appendChild(cancelButton);

    const saveButton = document.createElement('button');
    saveButton.textContent = 'SALVA';
    saveButton.className = 'btn btn-primary w-50 ms-1';
    const save = ()=> {
        element.value = input.value;
        const _data = {
            skip_cookie: true,
            operation: input.value === '' ? 'clean_hour' : 'hour',
            ora: input.value,
            row: element.closest('tr').getAttribute('row'),
            data: document.querySelector('.date-target').value,
            id_terapista: element.getAttribute('id_terapista')
        };
        $.post('post/planning.php', _data).done(success_and_refresh).fail(fail);
        card.remove();
    };
    saveButton.addEventListener('click', save);
    input.addEventListener('keydown', (event) => { if (event.key === 'Enter') save();});
    row.appendChild(saveButton);
    card.appendChild(row);
    document.body.appendChild(card);
}
document.addEventListener("DOMContentLoaded", () => {
    const dateTarget = document.querySelector('.date-target');
    var first = dateTarget.value;
    const observer = new MutationObserver(mutations => {
        mutations.forEach(mutation => {
            if (mutation.type === 'attributes' && mutation.attributeName === 'value') {
                let current = dateTarget.value;
                if(current!=first){
                    const [day, month, year] = current.split('/');
                    setCookie('currentMonth',month - 1,1);
                    setCookie('currentYear',year,1);
                    setCookie('currentDay',day,1);
                    window.location = sessionStorage.getItem('prenotazioni_url')+current;
                }
            }
        });
    });
    observer.observe(dateTarget, { attributes: true });
});
document.addEventListener('DOMContentLoaded', () => {
    const table = document.querySelector('.resizable-table');
    let isResizing = false;
    let startX, startWidth, targetCell;
    table.querySelectorAll('th, td').forEach(cell => {
        const resizer = document.createElement('div');
        resizer.classList.add('resizer');
        cell.appendChild(resizer);
        resizer.addEventListener('mousedown', (e) => {
            isResizing = true;
            startX = e.pageX;
            targetCell = cell;
            startWidth = cell.offsetWidth;
            document.body.classList.add('resizing');
            e.preventDefault();
        });
    });
    document.addEventListener('mousemove', (e) => {
        if (!isResizing) return;
        const delta = e.pageX - startX;
        targetCell.style.width = `${startWidth + delta}px`;
    });
    document.addEventListener('mouseup', () => {
        if (isResizing) {
        isResizing = false;
        document.body.classList.remove('resizing');
        }
    });
    setInterval(() => { console.log("Performing periodic check");}, 30000);
});
