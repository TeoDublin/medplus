const datepicker = require('js-datepicker');
const planning={
    datePick: document.querySelector('.planning-date'),
    listen: function(){
        const datePickClick = () => {
            alert('click');
        };
        this.datePick.addEventListener('click',datePickClick);
    }
}
planning.listen();
