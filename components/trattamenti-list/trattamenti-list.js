

const trattamenti = {
    bind:function(){
        document.querySelector('#id_trattamento').addEventListener('change',function(){
            let div_prezzo = document.querySelector('div#prezzo');
            let div_sedute = document.querySelector('div#sedute');
            if(this.value!==''){
                let element = this.querySelector("option[value='"+this.value+"']");
                if(element.getAttribute('tipo')==='Mensile'){
                    document.querySelector('input#prezzo').value = element.getAttribute('prezzo');
                    div_sedute.hidden = true; 
                }
                else{
                    document.querySelector('input#prezzo').value = document.querySelector('input#sedute').value * element.getAttribute('prezzo');
                    div_sedute.hidden = false;
                } 
                div_prezzo.hidden = false;
            }
            else{
                div_sedute.hidden = true;
                div_prezzo.hidden = true;
            }
        });
        document.querySelector('input#sedute').addEventListener('change',function(){
            let trattamento = document.querySelector('#id_trattamento');
            let element = trattamento.querySelector("option[value='"+trattamento.value+"']");
            document.querySelector('input#prezzo').value = this.value * element.getAttribute('prezzo');
        });
    }
}
