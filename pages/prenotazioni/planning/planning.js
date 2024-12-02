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
function hoverRow(element){
    document.querySelector('#planning_table').classList.remove('table-separate');
    document.querySelectorAll('.sbarra_hovered').forEach(cell=>{cell.classList.remove('sbarra_hovered');})
    document.querySelectorAll('.hovered').forEach(cell=>{cell.classList.remove('hovered');})
    if(element.classList.contains('sbarra')){
        const planning_motivi_id = element.getAttribute('planning_motivi_id');
        document.querySelectorAll(`[planning_motivi_id="${planning_motivi_id}"]`).forEach(cell => {
            cell.classList.add('sbarra_hovered');
        });
        document.querySelector('#planning_table').classList.add('table-separate');
    }
    else{
        const row = element.getAttribute('row');
        document.querySelectorAll(`[row="${row}"]`).forEach(cell => {
            cell.classList.add('hovered');
        });
    }

}
function sbarraClick(element){
    const planning_motivi_id = element.getAttribute('planning_motivi_id');
    new_modal('panning', 'sbarra', { 'id_terapista': document.querySelector('#terapista').value,'data':document.querySelector('#data').value, 'planning_motivi_id':planning_motivi_id,'row': element.getAttribute('row')});
}
function clickPrenota(){
    new_page_modal('panning', 'customer-picker', {});
}