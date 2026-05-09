window.modalHandlers['planning_calendar'] = {
    origins: ['sbarra', 'corso', 'seduta', 'colloquio'],
    rowClick: function(element, origin, id_terapista) {
        const planning_motivi_id = element.getAttribute('planning_motivi_id');
        const data = document.querySelector('#planning-calendar-data').value;

        switch (origin) {
            case 'sbarra':
            case 'empty':
                modal_component('sbarra', 'sbarra', {
                    id_terapista: id_terapista,
                    data: data,
                    planning_motivi_id: planning_motivi_id,
                    row: element.getAttribute('row')
                });
                break;
            case 'corso':
                modal_component('sbarra', 'sposta_corso', {
                    id_terapista: id_terapista,
                    data: data,
                    id_corso: planning_motivi_id,
                    row: element.getAttribute('row')
                });
                break;
            case 'seduta':
                modal_component('sbarra', 'sposta_seduta', {
                    id_terapista: id_terapista,
                    data: data,
                    id_seduta: planning_motivi_id,
                    row: element.getAttribute('row')
                });
                break;
            case 'colloquio':
                modal_component('sbarra', 'sposta_colloquio', {
                    id_terapista: id_terapista,
                    data: data,
                    id_seduta: planning_motivi_id,
                    row: element.getAttribute('row')
                });
                break;
            default:
                console.log(origin);
                break;
        }
    },
    enterRow: function(element, origin) {
        this.cleanHovered();
        if (origin !== 'empty') {
            const rowClass = origin + '_hovered';
            const planningMotiviId = element.getAttribute('planning_motivi_id');
            document.querySelectorAll(`[planning_motivi_id="${planningMotiviId}"]`).forEach(cell => {
                cell.classList.add(rowClass);
            });
        }
    },
    cleanHovered: function() {
        this.origins.forEach(origin => {
            document.querySelectorAll('.' + origin).forEach(cell => {
                cell.classList.remove(origin + '_hovered');
            });
        });
    },
    change: function() {
        refresh({
            tab: 'calendar',
            data: document.querySelector('#planning-calendar-data').value
        });
    },
    removeDay: function() {
        this.shiftDay(-1);
    },
    addDay: function() {
        this.shiftDay(1);
    },
    today: function() {
        document.querySelector('#planning-calendar-data').value = new Date().toISOString().split('T')[0];
        this.change();
    },
    goToDate: function(element) {
        document.querySelector('#planning-calendar-data').value = element.dataset.date;
        this.change();
    },
    create: function(element) {
        const firstSlot = document.querySelector('.planning-calendar-slot[data-origin="empty"]');
        if (firstSlot) {
            this.rowClick(firstSlot, 'empty', firstSlot.dataset.terapista);
        }
    },
    shiftDay: function(days) {
        const dataInput = document.querySelector('#planning-calendar-data');
        const currentDate = new Date(dataInput.value);
        currentDate.setDate(currentDate.getDate() + days);
        dataInput.value = currentDate.toISOString().split('T')[0];
        this.change();
    }
};

if (!window.colorInitialValues) {
    window.colorInitialValues = {};
}

document.querySelectorAll('.planning-calendar-shell .div-color-box').forEach(div => {
    const picker = div.querySelector('.color-picker');
    const cssVar = picker.dataset.target;
    let computedColor = getComputedStyle(document.documentElement).getPropertyValue(cssVar).trim();

    if (!computedColor || computedColor === 'initial') {
        computedColor = '#ffffff';
    } else {
        computedColor = planningCalendarRgbToHex(computedColor);
    }

    window.colorInitialValues[cssVar] = computedColor;
    picker.value = computedColor;

    picker.addEventListener('input', function() {
        document.documentElement.style.setProperty(this.dataset.target, this.value);
        document.querySelector('.planning-calendar-shell .preferences-btn').classList.remove('d-none');
    });

    div.addEventListener('click', function(event) {
        if (event.target !== picker) {
            picker.click();
        }
    });
});

const planningCalendarSaveBtn = document.getElementById('planning-calendar-save-btn');
if (planningCalendarSaveBtn) {
    planningCalendarSaveBtn.addEventListener('click', function() {
        const data = {};
        document.querySelectorAll('.planning-calendar-shell .color-picker').forEach(picker => {
            const cssVar = picker.dataset.target;
            data[cssVar] = picker.value;
            document.documentElement.style.setProperty(cssVar, picker.value);
        });

        $.post('post/utenti_preferenze.php', data).done(() => {
            planningCalendarHideButtons();
            success();
        }).fail(() => {
            fail();
        });
    });
}

const planningCalendarDiscardBtn = document.getElementById('planning-calendar-discard-btn');
if (planningCalendarDiscardBtn) {
    planningCalendarDiscardBtn.addEventListener('click', function() {
        document.querySelectorAll('.planning-calendar-shell .color-picker').forEach(picker => {
            const cssVar = picker.dataset.target;
            picker.value = window.colorInitialValues[cssVar];
            document.documentElement.style.setProperty(cssVar, window.colorInitialValues[cssVar]);
        });
        planningCalendarHideButtons();
    });
}

function planningCalendarHideButtons() {
    document.querySelector('.planning-calendar-shell .preferences-btn').classList.add('d-none');
}

function planningCalendarRgbToHex(rgb) {
    if (!rgb.startsWith('rgb')) return rgb;
    const match = rgb.match(/\d+/g);
    if (!match || match.length < 3) return '#ffffff';
    const [r, g, b] = match.map(Number);
    return `#${((1 << 24) | (r << 16) | (g << 8) | b).toString(16).slice(1)}`;
}
