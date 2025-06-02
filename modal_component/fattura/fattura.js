window.modalHandlers['fattura'] = Object.assign(
    window.modalHandlers['fattura'] || {}, {
    addTotal:function(element) {
        const modal = element.closest('.modal');
        const totale = modal.querySelector('#sum');
        let new_total = 0;
        modal.querySelectorAll('.importo').forEach(importo=>{
            let input = importo.querySelector('input').value;
            new_total+=parseFloat(input) || 0;
        });
        let inps = Math.round(new_total * 0.04 * 100) / 100;
        let bollo = 0;
        if((new_total+inps)>70){
            bollo = 2;            
        }
        new_total = new_total + inps + bollo;
        totale.value = parseFloat(new_total).toFixed(2);
        modal.querySelector('#inps').value=inps;
        modal.querySelector('#bollo').value=bollo;
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
        importoInput.addEventListener('change',function(){window.modalHandlers['fattura'].addTotal(importoInput)});
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
        
    }
});