window.modalHandlers['fattura'] = Object.assign(
    window.modalHandlers['fattura'] || {}, {
    addTotal:function(element) {
        const modal = element.closest('.modal');
        const totale = modal.querySelector('#totale');
        const imponibile = modal.querySelector('#imponibile');
        let new_total = 0;
        modal.querySelectorAll('.importo').forEach(importo=>{
            let input = importo.querySelector('input').value;
            new_total+=parseFloat(input) || 0;
        });
        totale.value = parseFloat(new_total).toFixed(2);
        imponibile.value = parseFloat(new_total).toFixed(2);
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
        window.modalHandlers['fattura'].addTotal(parent);
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
        document.querySelector('.oggetti').insertBefore(oggettoDiv, document.querySelector('.oggetti').children[1]);
    
        let countImporto = document.querySelectorAll('.importo_row').length;
        const importoDiv = document.createElement('div');
        importoDiv.className = "card-body ps-0 pe-1 pb-0 pt-1 importo importo_row";
        const importoInput = document.createElement('input');
        importoInput.id = 'importo' + (countImporto + 1);
        importoDiv.id = 'row' + (countImporto + 1);
        importoInput.className = 'form-control';
        importoInput.type = 'number';
        importoInput.addEventListener('change',function(){window.modalHandlers['fattura'].addTotal(importoInput)});
        importoDiv.appendChild(importoInput);
        document.querySelector('.importi').insertBefore(importoDiv, document.querySelector('.importi').children[1]);
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
    stampBtnClick:function(){
        const oggetto = document.querySelector('#oggettoBollo');
        const importo = document.querySelector('#importoBollo');
        const btn = document.querySelector('#btnBollo');
        const spanBollo = document.querySelector('#spanBollo');
        const bollo = document.querySelector('.bollo');
        if(btn.classList.contains('btn-dark')){
            oggetto.removeAttribute('disabled');
            oggetto.classList.remove('stampDisabled');
            importo.removeAttribute('disabled');
            importo.classList.remove('stampDisabled');
            btn.classList.add('btn-primary');
            btn.classList.remove('btn-dark');
            btn.setAttribute('title','ELIMINA MARCA DA BOLLO');
            spanBollo.removeAttribute('hidden');
            spanBollo.classList.remove('d-none');
            bollo.classList.add('importo');
            this.addTotal(spanBollo);
        }
        else{
            oggetto.setAttribute('disabled',true);
            oggetto.classList.add('stampDisabled');
            importo.setAttribute('disabled',true);
            importo.classList.add('stampDisabled');
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-dark');
            btn.setAttribute('title','AGGIUNGI MARCA DA BOLLO');
            spanBollo.setAttribute('hidden','');
            spanBollo.classList.add('d-none');
            bollo.classList.remove('importo');
            this.addTotal(spanBollo);
        }
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
        
    }
});