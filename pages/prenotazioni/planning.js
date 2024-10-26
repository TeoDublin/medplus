document.addEventListener("DOMContentLoaded", function() {
    const planning = {
        datepicker: document.querySelector('.datepicker'),
        lastValue: null,
        listen: function() {
            const refreshByDate = () => {
                alert("got here");
            };
            
            // Trigger when user changes the datepicker
            this.datepicker.addEventListener('change', refreshByDate);

            // Use MutationObserver to detect attribute changes
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'value') {
                        refreshByDate();
                    }
                });
            });
            
            observer.observe(this.datepicker, { attributes: true });
        }
    };
    planning.listen();
});
