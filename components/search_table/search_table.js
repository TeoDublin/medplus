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
    clickSearchInput:function(element){
        if(!element.classList.contains('searching')){
            element.classList.add('searching');
        }
        else{
            element.classList.remove('searching');
        }
    },
    searchTableBody:function(table,key,element,actions,cols){
        let _data={
            actions:actions,
            table:table,
            cols:cols
        };
        if(key&&element.value){
            _data['search']={key:key,value:element.value};
            if(!element.classList.contains('searching'))element.classList.add('searching');
        }
        
        $.post('post/search_table.php',_data).done(response=>{
            $.post('component.php', {response:response,component:'search_table_body'})
                .done(search_table_response => {
                    let search_table_body = document.querySelector('#search_table_body');
                    search_table_body.innerHTML = '';
                    search_table_body.innerHTML = search_table_response;
                    $.post('component.php', {response:response,component:'pagination'})
                        .done(pagination_response => {
                            let pagination = document.querySelector('#pagination');
                            pagination.innerHTML = '';
                            pagination.innerHTML = pagination_response;
                        });
                });
        });
    },
    clickOutsideListener: function(event) {
        document.querySelectorAll('.search_row').forEach(element=>{
            if (!element.contains(event.target)&&element.classList.contains('searching')) {
                element.classList.remove('searching')
            }
        })
    }
};