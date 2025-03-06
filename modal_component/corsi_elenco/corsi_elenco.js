window.modalHandlers['corsi_elenco']={
    btnSalva:function(element) {
        let _data = { days: [], clienti: [] };
        const modal = element.closest('.modal');
        modal.querySelectorAll('[name]').forEach(input => { _data[input.name] = input.value;});
        modal.querySelectorAll('.giorno_row').forEach(row => {
            console.log(row);
            _data['days'].push({
                giorno: row.querySelector('.giorno').value,
                inizio: row.querySelector('.inizio').value,
                fine: row.querySelector('.fine').value
            });
        });
        modal.querySelectorAll('.cliente_row').forEach(row => {
            _data['clienti'].push({
                cliente: row.querySelector('select.cliente').value,
                prezzo: row.querySelector('.prezzo').value,
                data_inizio: row.querySelector('.data_inizio').value
            });
        });
        $.post('post/corsi_elenco.php', _data).done(() => success_and_refresh()).fail(() => fail());
    },
    aggiungiGiorno(element){
        $.post('post/aggiungi_giorno.php').done(response =>{
            let div = document.createElement('div');
            div.classList = 'd-flex flex-row w-100 giorno_row py-1';
            div.innerHTML = response;
            element.closest('.modal').querySelector('div#table-body').append(div);
            this.bindBtn();
        });
    },
    aggiungiCliente(element){
        $.post('post/aggiungi_cliente.php',{'prezzo_tabellare':element.closest('.modal').querySelector('#prezzo_tabellare').value}).done(response =>{
            let div = document.createElement('div');
            div.classList = 'd-flex flex-row w-100 mt-2 cliente_row';
            div.innerHTML = response;
            element.closest('.modal').querySelector('div#table-body-clienti').append(div);
            this.bindBtnCliente();
        });
    },
    delEnter(element){
        element.closest('div.giorno_row').classList.add('warning');
    },
    delLeave(element){
        element.closest('div.giorno_row').classList.remove('warning');
    },
    delClick(element){
        element.closest('div.giorno_row').remove();
    },
    delEnterCliente(element){
        element.closest('div.cliente_row').classList.add('warning');
    },
    delLeaveCliente(element){
        element.closest('div.cliente_row').classList.remove('warning');
    },
    delClickCliente(element){
        element.closest('div.cliente_row').remove();
    },
    bindBtn() {
        document.querySelectorAll('.del-btn:not([data-bound])').forEach(btn => {
            btn.addEventListener('mouseenter', () => this.delEnter(btn));
            btn.addEventListener('mouseleave', () => this.delLeave(btn));
            btn.addEventListener('click', () => this.delClick(btn));
            btn.setAttribute('data-bound', 'true');
        });
    },
    bindBtnCliente() {
        document.querySelectorAll('.del-btn-cliente:not([data-bound])').forEach(btn => {
            btn.addEventListener('mouseenter', () => this.delEnterCliente(btn));
            btn.addEventListener('mouseleave', () => this.delLeaveCliente(btn));
            btn.addEventListener('click', () => this.delClickCliente(btn));
            btn.setAttribute('data-bound', 'true');
        });
        document.querySelectorAll('.cliente:not([data-bound])').forEach(select => {
            select.searchable();
            select.setAttribute('data-bound', 'true');
        });
    }
} 
window.modalHandlers['corsi_elenco'].bindBtn();
window.modalHandlers['corsi_elenco'].bindBtnCliente();