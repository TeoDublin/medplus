function _data(element, oggetti){
    element.querySelector('button').setAttribute('disabled',true);
    let table = [];
    for (let index = document.querySelectorAll('.oggetto').length; index >= 1; index--) {
        table.push({'oggetto':document.querySelector('#oggetto'+index)?.value,'importo':document.querySelector('#importo'+index)?.value});
    }
    oggetti['dati']=document.querySelector('#dati').value;
    oggetti['footer']=document.querySelector('#footer').value;
    oggetti['articolo']=document.querySelector('#articolo').value;
    oggetti['head']=document.querySelector('#head').value;
    oggetti['data']=document.querySelector('#date').value;
    oggetti['data_pagamento']=document.querySelector('#data_pagamento').value;
    oggetti['metodo_pagamento']=document.querySelector('#metodo_pagamento').value;
    oggetti['totale']=document.querySelector('#totale').value;
    oggetti['imponibile']=document.querySelector('#imponibile').value;
    if(!document.querySelector('#btnBollo').classList.contains('btn-dark')){
        oggetti['bollo']=document.querySelector('#importoBollo').value;
        oggetti['spanBollo']=document.querySelector('#spanBolloValue').value;
    }
    oggetti['table']=table;
    document.querySelectorAll('textarea[name]').forEach(element =>{ oggetti[element.getAttribute('name')]=element.textContent });
    return oggetti;
};