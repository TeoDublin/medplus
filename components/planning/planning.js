window.modalHandlers['planning'] = {
    origins : ['sbarra','corso','seduta'],
    enterRow:function(element,origin){
        this.cleanHovered();
        if(origin!=='empty'){
            const row_class = origin+'_hovered';
            document.querySelectorAll('.'+row_class).forEach(cell=>{cell.classList.remove(row_class);})
            document.querySelectorAll('.hovered').forEach(cell=>{cell.classList.remove('hovered');})
            const planning_motivi_id = element.getAttribute('planning_motivi_id');
            document.querySelectorAll(`[planning_motivi_id="${planning_motivi_id}"]`).forEach(cell => {
                cell.classList.add(row_class);
            });
        }
        
    },
    cleanHovered:function(){
        this.origins.forEach(origin=>{
            document.querySelectorAll('.'+origin).forEach(cell=>{cell.classList.remove(origin+'_hovered');})
        });
    },
}