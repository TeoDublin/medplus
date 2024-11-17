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
function deleteBtnClick(ele){
    let row=ele.getAttribute('row');
    document.querySelector('#oggetto'+row).remove();
    document.querySelector('#importi'+row).remove();
    ele.remove();
}
function deleteBtnEnter(ele){
    let row=ele.getAttribute('row');
    document.querySelector('#oggetto'+row).classList.add('deleteBtnEnter');
    document.querySelector('#importi'+row).classList.add('deleteBtnEnter');
}
function deleteBtnLeave(ele){
    let row=ele.getAttribute('row');
    document.querySelector('#oggetto'+row).classList.remove('deleteBtnEnter');
    document.querySelector('#importi'+row).classList.remove('deleteBtnEnter');
}