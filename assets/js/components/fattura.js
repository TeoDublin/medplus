function _data(element, oggetti){
    element.querySelector('button').setAttribute('disabled',true);
    let _data = {};
    let table = [];
    for (let index = document.querySelectorAll('.oggetto').length; index >= 1; index--) {
        table.push({'oggetto':document.querySelector('#oggetto'+index)?.value,'importo':document.querySelector('#importo'+index)?.value});
    }
    _data['dati']=document.querySelector('#dati').value;
    _data['footer']=document.querySelector('#footer').value;
    _data['articolo']=document.querySelector('#articolo').value;
    _data['head']=document.querySelector('#head').value;
    _data['data']=document.querySelector('#date').value+document.querySelector('#data_pagamento').value;
    _data['data_pagamento']=document.querySelector('#data_pagamento').value;
    _data['metodo_pagamento']=document.querySelector('#metodo_pagamento').value;
    _data['totale']=document.querySelector('#totale').value;
    _data['imponibile']=document.querySelector('#imponibile').value;
    if(!document.querySelector('#btnBollo').classList.contains('btn-dark')){
        _data['bollo']=document.querySelector('#importoBollo').value;
        _data['spanBollo']=document.querySelector('#spanBolloValue').value;
    }
    _data['table']=table;
    _data['oggetti']=oggetti;
    document.querySelectorAll('textarea[name]').forEach(element =>{ _data[element.getAttribute('name')]=element.textContent });
    return _data;
};