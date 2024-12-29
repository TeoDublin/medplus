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
function changeTerapista(){
    refresh({id_terapista:document.querySelector('#terapista').value});
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
    if(!element.classList.contains('seduta')){
        const planning_motivi_id = element.getAttribute('planning_motivi_id');
        modal_component('planning', 'sbarra', { 'id_terapista': document.querySelector('#terapista').value,'data':document.querySelector('#data').value, 'planning_motivi_id':planning_motivi_id,'row': element.getAttribute('row')});
    }
}