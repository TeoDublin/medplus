window.modalHandlers['terapisti_percentuali'] = {
    btnSalva: function (e) {

        const $modal = e.closest('.modal');

        let $terapista =  $modal.querySelector('#terapista');
        $terapista.classList.remove('bg-warning');

        if( $terapista.value === ''){
            alert('Devi scrivere un nome terapista');
            $terapista.classList.add('bg-warning');
            return;
        }

        const _data = {
            id: $modal.dataset.id,
            terapista: $terapista.value,
            profilo: $modal.querySelector('#profilo').value,
            trattamenti_medplus: $modal.querySelector('#trattamenti_medplus').value,
            trattamenti_isico_salerno: $modal.querySelector('#trattamenti_isico_salerno').value,
            trattamenti_isico_napoli: $modal.querySelector('#trattamenti_isico_napoli').value,
            trattamenti_dz:  $modal.querySelector('#trattamenti_dz').value,
            corsi_medplus: $modal.querySelector('#corsi_medplus').value,
            corsi_isico_salerno: $modal.querySelector('#corsi_isico_salerno').value,
            corsi_isico_napoli: $modal.querySelector('#corsi_isico_napoli').value,
            corsi_dz: $modal.querySelector('#corsi_dz').value
        }

        $.post(
            'modal_component/terapisti_percentuali/post/terapisti_percentuali.php',
            _data
        )
        .done( (response) => {

            if(!response.success){
                alert(response.message);
                fail();
            }
            else{
                success_and_refresh();
            }
        })
        .fail(() => {
            fail();
        });

    }
};
