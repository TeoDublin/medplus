window.modalHandlers['fattura'] = {

    addSpinner:function(){
        const div = document.createElement('div');
        div.id = 'div_fattura_spinner';
        div.style = 'z-index:99999!important';
        div.innerHTML = spinner();
        document.querySelector('#modal_fattura').appendChild(div);
        return div;
    },

    deleteBtnEnter:function(ele){
        document.querySelectorAll('#'+ele.id).forEach(element=>{ element.classList.add('deleteBtnEnter');});
    },

    deleteBtnLeave:function(ele){
        document.querySelectorAll('#'+ele.id).forEach(element=>{ element.classList.remove('deleteBtnEnter');});
    },

    deleteBtnClick:function(ele){
        const parent = ele.closest('.card');
        document.querySelectorAll('#'+ele.id).forEach(element=>{ element.remove();});
        this.updateRowId();
    },

    addBtnClick:function() {

        let countOggetto = document.querySelectorAll('.oggetto').length;
        const oggettoDiv = document.createElement('div');
        oggettoDiv.className = "card-body pe-1 pb-0 pt-1 oggetto";
        const oggettoInput = document.createElement('input');
        oggettoInput.id = 'oggetto' + (countOggetto + 1);
        oggettoDiv.id = 'row' + (countOggetto + 1);
        oggettoInput.className = 'form-control';
        oggettoDiv.appendChild(oggettoInput);
        const oggettiContainer = document.querySelector('.titleOggetti');

        if (countOggetto === 0) {
            oggettiContainer.insertAdjacentElement('afterend',oggettoDiv);
        } else {
            document.querySelector('.oggetto').insertAdjacentElement('afterend', oggettoDiv);
        }

        let countImporto = document.querySelectorAll('.importo_row').length;
        const importoDiv = document.createElement('div');
        importoDiv.className = "card-body ps-0 pe-1 pb-0 pt-1 importo importo_row";
        const importoInput = document.createElement('input');
        importoInput.id = 'importo' + (countImporto + 1);
        importoDiv.id = 'row' + (countImporto + 1);
        importoInput.className = 'form-control';
        importoInput.type = 'number';
        importoDiv.appendChild(importoInput);
        const importoContainer = document.querySelector('.titleImporti');

        if (countImporto === 0) {
            importoContainer.insertAdjacentElement('afterend',importoDiv);
        } else {
            document.querySelector('.importo').insertAdjacentElement('afterend', importoDiv);
        }

        let countBtn = document.querySelectorAll('.delBtn').length;
        
        const btnContainer  = document.createElement('div');
        btnContainer.className = 'card-body ps-0 pe-1 pb-0 pt-1 delBtn';
        btnContainer.setAttribute('title','ELIMINA');
        btnContainer.id = 'row' + (countBtn + 1);
        const btnDiv = document.createElement('div');
        btnDiv.className = "pe-0";
        const btn = document.createElement('button');
        btn.className = 'btn btn-primary w-100';
    
        const a = document.createElement('a');
        a.className = 'me-2';
        const svgImg = document.createElement('img');
        svgImg.src = 'assets/icons/bin-white.svg';
        svgImg.alt = 'Delete';
        svgImg.className = 'bi bi-trash3-fill';
    
        a.appendChild(svgImg);
        btn.appendChild(a);
        btnDiv.appendChild(btn);
        btnContainer.appendChild(btnDiv);
        btnContainer.addEventListener('mouseenter',function(){window.modalHandlers['fattura'].deleteBtnEnter(btnContainer)});
        btnContainer.addEventListener('mouseleave',function(){window.modalHandlers['fattura'].deleteBtnLeave(btnContainer)});
        btnContainer.addEventListener('click',function(){window.modalHandlers['fattura'].deleteBtnClick(btnContainer)});
        document.querySelector('.btns').insertBefore(btnContainer, document.querySelector('.btns').children[1]);
        this.updateRowId();
    },

    stampBtnEnter:function(ele){
        document.querySelectorAll('#'+ele.id).forEach(element=>{ element.classList.add('stampBtnEnter');});
    },

    stampBtnLeave:function(ele){
        document.querySelectorAll('#'+ele.id).forEach(element=>{ element.classList.remove('stampBtnEnter');});
    },

    updateRowId:function(){
        let row = 1;
        document.querySelectorAll('div.oggetto').forEach(function(e){
            e.id="row"+row;
            e.querySelector('input').id="oggetto"+row;
            row++;
        });
        row = 1;
        document.querySelectorAll('div.importo_row').forEach(function(e){
            e.id="row"+row;
            e.querySelector('input').id="importo"+row;
            row++;
        });
        row = 1;
        document.querySelectorAll('div.delBtn').forEach(function(e){
            e.id="row"+row;
            row++;
        });
        
    },

    generatePDF:function(e) {

        let total_percorsi_child = 0;
        const oggetti = [];

        const $modal = e.closest('.modal');

        const $oggetti = $modal.querySelectorAll('div.oggetto');
        const totale = parseFloat($modal.querySelector('input#sum').value);
        const index = parseInt($modal.querySelector('select#index').value);
        const data_creazione = $modal.querySelector('input#data_creazione').value;
        const metodo_pagamento = $modal.querySelector('select#metodo_pagamento').value;
        const inps = $modal.querySelector('input#inps').value;
        const bollo = $modal.querySelector('input#bollo').value;
        const dataPayload = payload();
        const imponibile = totale - inps - bollo;

        if (!Number.isInteger(index) || index <= 0) {
            alert('Index non valido');
            return;
        }

        if (!data_creazione) {
            alert('Data pagamento mancante');
            return;
        }

        if (!metodo_pagamento) {
            alert('Metodo pagamento mancante');
            return;
        }

        $modal.querySelectorAll('.importo_row').forEach((importo_row) => {
            let input = parseInt(importo_row.querySelector('input').value) || 0;
            total_percorsi_child += input;
        });

        console.log(imponibile);
        console.log(total_percorsi_child);

        if ( imponibile !== total_percorsi_child) {
            alert('La somma degli importi non è uguale al totale');
            return;
        }
        
        if(!$oggetti.length){
            alert('Devi aggiungere almeno uno oggetto');
            return;  
        }

        for(const $oggetto of $oggetti){

            let oggetto = $oggetto.querySelector('input').value;
            let importo = $modal.querySelector('div.importo_row#' + $oggetto.id).querySelector('input').value;

            if(!oggetto){
                alert('L\'ggetto non puo essere vuoto');
                break;   
            }

            if(!importo){
                alert('L\'importo non puo essere vuoto');
                break;   
            }

            oggetti.push({
                oggetto: oggetto,
                importo: parseFloat(importo) || 0
            });

        }

        const spinnerDiv = this.addSpinner();

        $.post(
            'modal_component/fattura/post/fattura.php', 
            {
                payload: dataPayload,
                index : index,
                data_creazione: data_creazione,
                metodo_pagamento: metodo_pagamento,
                totale: totale,
                inps: inps,
                bollo: bollo,
                oggetti: oggetti
            }
        ).done((response) => {

            window.open(response, '_blank');

            reload_modal_component(
                'percorsi_pendenze',
                'percorsi_pendenze',
                {
                    id_cliente: dataPayload.data_cliente.id
                }
            );
        }).fail(function(){
            fail();
        }).always(() => {
            spinnerDiv.remove();
        });
    }
};