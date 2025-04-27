window.modalHandlers['input_excel_fatture'] = {
    btnSalva: function(element) {
        const mnodal = element.closest('.modal');
        const form = mnodal.querySelector('#excelUploadForm');
        const fileInput = form.querySelector('input[type="file"]');

        if (!fileInput.files.length) {
            alert("Seleziona un file prima di continuare.");
            return;
        }

        const formData = new FormData();
        formData.append("file", fileInput.files[0]);
        formData.append("table", "fatture");

        $.ajax({
            url: 'post/input_excel_fatture.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function() {
                success_and_refresh();
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let msg = "Errore nei dati del file Excel:";
                    xhr.responseJSON.response.forEach(row => {
                        for (let key in row) {
                            if (row[key] && typeof row[key] === 'object' && row[key].error) {
                                msg += "\nRiga ID " + row.id + ": " + row[key].error;
                            }
                        }
                    });
                    alert(msg);
                } else {
                    fail();
                }
            }
                     
        });
    }
};
