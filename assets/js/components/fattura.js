function _data(e){
    e.querySelector('button').setAttribute('disabled',true);
    const modal = e.closest('.modal');
    let table = [];
    let oggetti = {};
    let importo = 0;
    const oggettiElements = modal.querySelectorAll('.oggetto');
    for (let index = 1; index <= oggettiElements.length; index++) {
        let _importo = modal.querySelector('#importo' + index)?.value;
        importo += parseFloat(_importo);
        table.push({
            'oggetto': modal.querySelector('#oggetto' + index)?.value,
            'importo': _importo
        });
    }

    oggetti['id_cliente']=modal.querySelector('#id_cliente').value;
    oggetti['data_pagamento']=modal.querySelector('#data_pagamento').value;
    oggetti['metodo_pagamento']=modal.querySelector('#metodo_pagamento').value;
    oggetti['sum']=modal.querySelector('#sum').value;
    oggetti['bollo']=modal.querySelector('#bollo').value;
    oggetti['inps']=modal.querySelector('#inps').value;
    oggetti['index']=modal.querySelector('#index').value;
    oggetti['table']=table;
    oggetti['importo']=importo;
    return oggetti;
};