window.modalHandlers['corsi_esporta']={
    btnSalva:function(element){
        const modal = element.closest('.modal');
        month=modal.querySelector('#month').value;
        excel('post/excel_corsi.php',{month:month});
    }
} 
