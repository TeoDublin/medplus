window.modalHandlers['add_cliente'] = {
    btnSalva: function (element) {
        let formData = new FormData();
        formData.append('table', 'clienti');

        const modal = element.closest('.modal');
        modal.querySelectorAll('[name]').forEach(el => {
            if (el.type === 'file') {
                if (el.files.length > 0) formData.append(el.name, el.files[0]);
            } else if (el.type === 'checkbox' || el.type === 'radio') {
                if (el.checked) formData.append(el.name, el.value);
            } else {
                formData.append(el.name, el.value);
            }
        });
        

        $.ajax({
            url: 'post/add_cliente.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function () { success_and_refresh(); },
            error: function () { fail(); }
        });
    }
};
