window.modalHandlers['percorsi_pendenze'] = {
    closePersistent:'fattura',
    realizzato_da:function(_data){
        let realizzato_da = null;
        _data.forEach((v)=>{
            if(realizzato_da==null){
                realizzato_da=v.realizzato_da;
            }
            if(v.realizzato_da !== realizzato_da){
                alert('Non puoi fatturare Isico e Medplus insieme');
                hasError=true;
                return {hasError:true}; 
            }
        });
        return {hasError:false, realizzato_da:realizzato_da};
    },
    fatturaClick:function(){
        let hasError=false;
        const raw = document.querySelector('#data_cliente').textContent.trim();
        let _data = this._data();
        if(!this.realizzato_da(_data).hasError){
            let error = 'Per generare la fattura devi inserire i dati:\n\n';
            try {
                let data_cliente = JSON.parse(raw);
                if (!data_cliente || Object.keys(data_cliente).length === 0) {
                    hasError=true;
                    error+='- Cliente\n';
                } 
                else {

                    if(!data_cliente.id||data_cliente.id==''){
                        hasError=true;
                        error+='- Nominativo\n';
                    }
                    if(!data_cliente.indirizzo||data_cliente.indirizzo==''){
                        hasError=true;
                        error+='- Indirizzo\n';
                    }
                    if(!data_cliente.cap||data_cliente.cap==''){
                        hasError=true;
                        error+='- Cap\n';
                    }
                    if(!data_cliente.citta||data_cliente.citta==''){
                        hasError=true;
                        error+='- Citta\n';
                    }
                    if(!data_cliente.cf||data_cliente.cf==''){
                        hasError=true;
                        error+='- Codice fiscale\n';
                    }
                    if(hasError){
                        alert(error);
                    }
                    else{
                        modal_component('fattura','fattura',{data:_data,data_cliente:data_cliente});
                    }
                }
            } 
            catch {
                hasError=true;
                error+='- Cliente\n';
            }   
        }

    },
    senzaFatturaClick:function(id_cliente){
        let _data = this._data();
        const realizzato_da=this.realizzato_da(_data);
        if(!realizzato_da.hasError){
            if(realizzato_da.realizzato_da=='Isico'){
                modal_component('pagamento_isico','pagamento_isico',{id_cliente:id_cliente,_data:_data});
            }
            else{
                modal_component('senza_fattura','senza_fattura',{id_cliente:id_cliente,_data:_data});
            }
        }
    },
    arubaClick:function(id_cliente){
        let _data = this._data();
        const realizzato_da=this.realizzato_da(_data);
        if(!realizzato_da.hasError){
            modal_component('fatturato_aruba','fatturato_aruba',{id_cliente:id_cliente,_data:_data});
        }
    },
    toggleBtns:function(){
        let btn = document.querySelector('.floating-btns');
        if(document.querySelectorAll('.checked').length >0){
            if(btn.classList.contains('d-none')){
                btn.classList.remove('d-none');
            }
        }
        else btn.classList.add('d-none');
    },
    check:function(e){
        let element = e.querySelector('.form-check');
        const prezzo = parseFloat(e.querySelector('.prezzo').textContent);
        let sumSelected = parseFloat(document.querySelector('#sum-selected').textContent);

        if(e.classList.contains('checked')){
            e.classList.remove('checked');
            element.checked = false;
            sumSelected-=prezzo;
        }
        else {
            e.classList.add('checked');
            element.checked = true;
            sumSelected+=prezzo;
        }
        document.querySelector('#sum-selected').textContent = sumSelected;
        this.toggleBtns();
    },
    uncheckAll:function(){
        document.querySelectorAll('.checked').forEach((div)=>{
            div.querySelector('.form-check').checked = false;
            div.classList.remove('checked');
        });
        document.querySelector('#sum-selected').textContent = 0;
        this.toggleBtns();
    },
    _data:function(){
        let _data = [];
        document.querySelectorAll('.checked').forEach((div)=>{
            _data.push(div.dataset);
        });
        return _data;
    },
    changePrice:function(id_cliente){
        modal_component('percorsi_modifica_prezzo','percorsi_modifica_prezzo',{id_cliente:id_cliente,data:this._data()});
    },
    del:function(id_cliente){
        if(confirm('Sicuro di voler procedere ?')){
            $.post('post/percorsi_del.php',{id_cliente:id_cliente,data:this._data()}).done(()=>{ 
                reload_modal_component('percorsi_pendenze','percorsi_pendenze',{id_cliente:id_cliente});
            }).fail(()=>{fail()});
        }
    }
}
window.modalHandlers['fattura'] = Object.assign(
    window.modalHandlers['fattura'] || {},{
    persistent:true,

    generatePDF:function(e,id_cliente,oggetti) {
        const _oggetti=JSON.parse(oggetti);
        $.post('post/fattura.php',{..._data(e), ..._oggetti}).done(response=>{
            window.open(response,'_blank');
            reload_modal_component('percorsi_pendenze','percorsi_pendenze',{id_cliente:id_cliente});
        });
    },
});