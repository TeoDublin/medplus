let origins = ['sbarra','corso','seduta'];

function openCalendar(event, element) {
    const rect = event.target.getBoundingClientRect();
    $.post('component.php', { component: 'calendar' })
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
function change(){
    refresh({
        id_terapista:document.querySelector('#terapista').value,
        data:document.querySelector('#data').value,
        rows:document.querySelector('#rows').value
    });
}
document.addEventListener("DOMContentLoaded", () => {
    const dateTarget = document.querySelector('#data');
    var first = dateTarget.value;
    const observer = new MutationObserver(mutations => {
        mutations.forEach(mutation => {
            if (mutation.type === 'attributes' && mutation.attributeName === 'value') {
                let current = dateTarget.value;
                if(current!=first){
                    const [day, month, year] = current.split("/");
                    setCookie('currentMonth',month - 1,1);
                    setCookie('currentYear',year,1);
                    setCookie('currentDay',day,1);
                    refresh({data:`${year}-${month}-${day}`});
                }
            }
        });
    });
    observer.observe(dateTarget, { attributes: true });
});
function enterRow(element,origin){
    cleanHovered();
    if(origin!=='empty'){
        const row_class = origin+'_hovered';
        document.querySelectorAll('.'+row_class).forEach(cell=>{cell.classList.remove(row_class);})
        document.querySelectorAll('.hovered').forEach(cell=>{cell.classList.remove('hovered');})
        const planning_motivi_id = element.getAttribute('planning_motivi_id');
        document.querySelectorAll(`[planning_motivi_id="${planning_motivi_id}"]`).forEach(cell => {
            cell.classList.add(row_class);
        });
    }
    
}
function cleanHovered(){
    origins.forEach(origin=>{
        document.querySelectorAll('.'+origin).forEach(cell=>{cell.classList.remove(origin+'_hovered');})
    });
}
function rowClick(element,origin){
    const planning_motivi_id = element.getAttribute('planning_motivi_id');
    switch (origin) {
        case 'sbarra':
        case 'empty':
            modal_component('modal', 'sbarra', { 'id_terapista': document.querySelector('#terapista').value,'data':document.querySelector('#data').value, 'planning_motivi_id':planning_motivi_id,'row': element.getAttribute('row')});
            break;
    
        default:
            console.log(origin);
            break;
    }
}