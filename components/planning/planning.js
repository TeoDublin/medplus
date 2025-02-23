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
    tab:function(tab,element){
        const tables_by_page=3;
        const last_table=tables_by_page*parseInt(tab);
        document.querySelectorAll('.table-terapista').forEach(table=>{
            table.classList.add('d-none');
        });
        document.querySelectorAll('.nav-link').forEach(nav=>{
            nav.classList.remove('active');
        });
        element.querySelector('.nav-link').classList.add('active');
        for(let i=0;i<tables_by_page;i++){
            let table = document.querySelector('.terapista-'+(last_table-i));
            if(table){
                table.classList.remove('d-none');
            }
        }
    }
}
if (!window.colorInitialValues) {
    window.colorInitialValues = {};
}

document.querySelectorAll(".div-color-box").forEach(div => {
    let picker = div.querySelector('.color-picker');
    const cssVar = picker.dataset.target;
    let computedColor = getComputedStyle(document.documentElement).getPropertyValue(cssVar).trim();
    if (!computedColor || computedColor === "initial") {
        computedColor = "#ffffff";
    } else {
        computedColor = rgbToHex(computedColor);
    }
    
    colorInitialValues[cssVar] = computedColor;
    
    picker.value = computedColor;

    picker.addEventListener("input", function () {
        document.documentElement.style.setProperty(this.dataset.target, this.value);
        document.querySelector('.preferences-btn').classList.remove('d-none');
    });

    div.addEventListener("click", function () {
        picker.click();
    });

});

document.getElementById("save-btn").addEventListener("click", function () {
    let _data = {};
    document.querySelectorAll(".color-picker").forEach(picker => {
        const cssVar = picker.dataset.target;
        _data[cssVar]=picker.value;
        document.documentElement.style.setProperty(cssVar, picker.value);
    });
    $.post('post/utenti_preferenze.php',_data).done(()=>{
        hideButtons();
        success();
    }).fail(()=>{fail();})
    
});

document.getElementById("discard-btn").addEventListener("click", function () {
    document.querySelectorAll(".color-picker").forEach(picker => {
        const cssVar = picker.dataset.target;
        picker.value = colorInitialValues[cssVar];
        document.documentElement.style.setProperty(cssVar, colorInitialValues[cssVar]);
    });
    hideButtons();
});

function hideButtons() {
    document.querySelector('.preferences-btn').classList.add('d-none');
}

function rgbToHex(rgb) {
    if (!rgb.startsWith("rgb")) return rgb;
    const match = rgb.match(/\d+/g);
    if (!match || match.length < 3) return "#ffffff";
    const [r, g, b] = match.map(Number);
    return `#${((1 << 24) | (r << 16) | (g << 8) | b).toString(16).slice(1)}`;
}
