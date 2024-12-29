window.modalHandlers['search_table'] = {
    enterSearchInput:function(element){
        if(!element.classList.contains('searching')){
            const data_value=element.getAttribute('data-value');
            element.value='';
            element.setAttribute('placeholder','Cerca '+data_value);
        }
    },
    leaveSearchInput:function(element){
        if(!element.classList.contains('searching')){
            const data_value=element.getAttribute('data-value');
            element.value=data_value;
            element.setAttribute('placeholder','');
        }
    },
    searchTableBody:function(table,key,element,actions,cols){
        console.log(cols);
        let _data={
            actions:actions,
            table:table,
            cols:cols
        };
        if(key&&element.value){
            _data['search']={key:key,value:element.value};
            if(!element.classList.contains('searching'))element.classList.add('searching');
        }
        else if(!element.value||element.value=='')element.classList.remove('searching');
        
        $.post('post/search_table.php',_data).done(response=>{
            $.post('component.php', {response:response,component:'search_table_body'})
                .done(search_table_response => {
                    let search_table_body = document.querySelector('#search_table_body');
                    search_table_body.innerHTML = '';
                    search_table_body.innerHTML = search_table_response;
                });
        });
    }
};