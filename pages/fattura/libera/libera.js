function generatePDF() {
    let _data = {};
    document.querySelectorAll('textarea[name]').forEach(element =>{ _data[element.getAttribute('name')]=element.textContent });
    $.post('post/fattura_libera.php',_data).done(response => {
        const link = document.createElement('a');
        link.href = response; 
        link.target = '_blank'; 
        link.click();
    });
}
function addBtnClick(ele) {
    let countOggetto = document.querySelectorAll('.oggetto').length;
    const oggettoDiv = document.createElement('div');
    oggettoDiv.className = "card-body pe-1 pb-0 pt-1 oggetto";
    oggettoDiv.id = 'oggetto' + (countOggetto + 1);
    const oggettoInput = document.createElement('input');
    oggettoInput.className = 'form-control';
    oggettoDiv.appendChild(oggettoInput);
    document.querySelector('.oggetti').insertBefore(oggettoDiv, document.querySelector('.oggetti').children[1]);

    let countImporto = document.querySelectorAll('.importo').length;
    const importoDiv = document.createElement('div');
    importoDiv.className = "card-body ps-0 pe-1 pb-0 pt-1 importo";
    importoDiv.id = 'importo' + (countImporto + 1);
    const importoInput = document.createElement('input');
    importoInput.className = 'form-control';
    importoInput.type = 'number';
    importoDiv.appendChild(importoInput);
    document.querySelector('.importi').insertBefore(importoDiv, document.querySelector('.importi').children[1]);

    let countBtn = document.querySelectorAll('.delBtn').length;
    const btnContainer  = document.createElement('div');
    btnContainer.className = 'card-body ps-0 pe-1 pb-0 pt-1 delBtn';
    btnContainer.setAttribute('title','ELIMINA');
    btnContainer.setAttribute('row',countBtn+ 1);
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
    btnContainer.addEventListener('mouseenter',function(){deleteBtnEnter(btnContainer)});
    btnContainer.addEventListener('mouseleave',function(){deleteBtnLeave(btnContainer)});
    btnContainer.addEventListener('click',function(){deleteBtnClick(btnContainer)});
    document.querySelector('.btns').insertBefore(btnContainer, document.querySelector('.btns').children[1]);
}

function deleteBtnEnter(ele){
    let row=ele.getAttribute('row');
    document.querySelector('#oggetto'+row).classList.add('deleteBtnEnter');
    document.querySelector('#importo'+row).classList.add('deleteBtnEnter');
}
function deleteBtnLeave(ele){
    let row=ele.getAttribute('row');
    document.querySelector('#oggetto'+row).classList.remove('deleteBtnEnter');
    document.querySelector('#importo'+row).classList.remove('deleteBtnEnter');
}
function deleteBtnClick(ele){
    let row=ele.getAttribute('row');
    document.querySelector('#oggetto'+row).remove();
    document.querySelector('#importo'+row).remove();
    ele.remove();
}