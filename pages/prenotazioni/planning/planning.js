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
function openHourPicker(event, element) {
    document.querySelectorAll('#hourPicker').forEach((element) => { element.remove(); });
    const id = element.id;
    const rect = event.target.getBoundingClientRect();
    const x = rect.x + window.scrollX;
    const y = rect.y + window.scrollY;

    $.post('component.php', { name: 'hour-picker' })
        .done(data => {
            const content = document.createElement('div');
            content.id = "hourPicker";
            content.setAttribute('style', 'left:' + x + 'px;top:' + y + 'px;position:absolute;');
            content.innerHTML = data;
            document.querySelector('.page-content').appendChild(content);

            hourPicker.start('#' + id + ' > input');
            hourPicker.closeBtn.addEventListener('click', () => {
                const _data = {
                    skip_cookie: true,
                    operation: 'hour',
                    row: element.closest('tr').getAttribute('row'),
                    data: document.querySelector('.date-target').value,
                    ora: hourPicker.value.value,
                    id_terapista: element.getAttribute('id_terapista')
                };
                $.post('post/planning.php', _data).done(response => { success(); }).fail(error => { fail(error); });
            });
            hourPicker.cleanBtn.addEventListener('click', () => {
                const _data = {
                    skip_cookie: true,
                    operation: 'clean_hour',
                    row: element.closest('tr').getAttribute('row'),
                    data: document.querySelector('.date-target').value,
                    ora: hourPicker.value.value,
                    id_terapista: element.getAttribute('id_terapista')
                };
                $.post('post/planning.php', _data).done(response => { success(); }).fail(error => { fail(error); });
            });
        })
        .fail(error => {
            console.error('Error fetching hourPicker:', error);
        });
}
function openCustomerPicker(element) {
    let _data={
        'name':'customer-picker',
        'skip_cookie':true,
        'row':element.closest('tr').getAttribute('row'),
        'data':document.querySelector('.date-target').value,
        'id_terapista':element.getAttribute('id_terapista')
    };
    $.post('component.php', _data, function(data) {
        document.querySelector('#modal-body').innerHTML = data;
        const modalElement = document.getElementById('modal');
        const modal = new bootstrap.Modal(modalElement);
        modalElement.querySelector('.modal-title').textContent = 'Seleziona cliente';
        modalElement.querySelector('.modal-dialog').classList.add('modal-xl');
        const addButton = modalElement.querySelector('.btn-add');
        addButton.replaceWith(addButton.cloneNode(true));
        const newAddButton = modalElement.querySelector('.btn-add');                
        modalElement.querySelector('.btn-add').addEventListener('click', () => {
            const input = element.querySelector('input');
            let nominativo = modalElement.querySelector('#nominativo').value;
            let trattamento = modalElement.querySelector('#id_trattamento');
            let options = trattamento.querySelectorAll('option');
            let optionText = Array.from(trattamento.options).find(opt => opt.value == trattamento.value)?.textContent;
            input.value = nominativo + ' > '+optionText;
            const _data = {};
            _data['operation']='all';
            _data['skip_cookie']=true;
            _data['row']=element.closest('tr').getAttribute('row');
            _data['data']=document.querySelector('.date-target').value;
            _data['ora']=element.closest('tr').querySelector('.hour-target').value;
            _data['id_terapista']=element.getAttribute('id_terapista');
            modalElement.querySelectorAll('[name]').forEach((modalInput)=>{ _data[modalInput.name] = modalInput.value; });
            modal.hide();
            $.post('post/planning.php',_data).done(success).fail(fail);
        });
        trattamenti.bind();
        modal.show();
    })
    .catch(error => {
        console.error('Error fetching customer picker:', error);
    });
}
document.addEventListener("DOMContentLoaded",()=>{
    function note(element){
        const _data = {};
        _data['skip_cookie']=true;
        _data['operation']='note';
        _data['note']=element.value;
        _data['row']=element.closest('tr').getAttribute('row');
        _data['data']=document.querySelector('.date-target').value;
        _data['id_terapista']=element.getAttribute('id_terapista');
        $.post('post/planning.php',_data).done(success).fail(fail);
    };
    document.querySelectorAll('.note').forEach(element=>{
        element.addEventListener('change',event=>note(event.target));
    });
});
document.addEventListener("DOMContentLoaded", () => {
    const obsList = document.querySelectorAll('.note');
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
});