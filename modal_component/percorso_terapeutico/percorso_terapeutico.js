function btnSalva(){
    let _data = {table:'percorsi'};
    document.querySelectorAll('[name]').forEach(element=>{
        _data[element.name]=element.value;
    });
    $.post('post/save.php',_data).done(function(){
        success();
        document.querySelector('.modal.show').modalInstance.hide();
    }).fail(fail());
}