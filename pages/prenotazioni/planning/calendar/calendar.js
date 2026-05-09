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
            data: document.querySelector('#planning-calendar-data').value,
            periodo: document.querySelector('#planning-calendar-periodo').value
        });
    },
    setPeriodo: function(periodo) {
        document.querySelector('#planning-calendar-periodo').value = periodo;
        this.change();
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
