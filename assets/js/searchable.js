Element.prototype.searchable = function(callback = false) {
    const select = this;
    if (select.tagName !== 'SELECT') {
        console.log('searchable must be a select');
        return;
    } else {
        let clickedOption = false;
        const dropDownId = 'dropDown_' + Math.random().toString(36).slice(2, 11);
        const inputId = 'input_' + Math.random().toString(36).slice(2, 11);
        let input = document.createElement('input');
        let dropDown = document.createElement('div');
        let dropDownUl = document.createElement('ul');
        input.id = inputId;
        dropDown.id = dropDownId;
        dropDownUl.classList.add('list-group');
        dropDown.classList.add('d-none', 'searchable-dropdown');

        let searchMessage = document.createElement('li');
        searchMessage.classList.add('list-group-item','rounded-0','label');
        searchMessage.textContent = "Cerca...";
        dropDownUl.appendChild(searchMessage);

        if (!callback) {
            select.querySelectorAll('option').forEach(opt => {
                let option = document.createElement('li');
                option.dataset.value = opt.value;
                option.innerHTML = opt.innerHTML;
                option.classList.add('list-group-item');
                option.classList.add('d-none');
                dropDownUl.appendChild(option);
                if(select.value!=''&&opt.value==select.value){
                    clickedOption=true;
                    input.value = opt.innerHTML;
                }
            });
        }

        input.classList.add(...select.classList);
        select.parentNode.classList.add('searchable-parent');
        select.parentNode.insertBefore(input, this);
        dropDown.appendChild(dropDownUl);
        select.parentNode.insertBefore(dropDown, input.nextSibling);

        dropDownUl.addEventListener('click', function(event) {
            if (event.target.tagName === 'LI' && event.target.dataset.value) {
                input.value = event.target.innerText;
                select.value = event.target.dataset.value;
                clickedOption = true;
                dropDown.classList.add('d-none');
                const changeEvent = new Event('change');
                select.dispatchEvent(changeEvent);
            }
        });

        input.addEventListener('click', function(e) {
            e.preventDefault();
            setTimeout(() => {
                if (document.getElementById(dropDownId)) {
                    document.getElementById(dropDownId).classList.remove('d-none');
                }
            }, 200);
        });

        document.addEventListener('click', function(event) {
            if (!dropDown.contains(event.target) && !input.contains(event.target)) {
                if (!clickedOption) {
                    input.value = '';
                }
                dropDown.classList.add('d-none');
            }
        });

        input.addEventListener('input', function() {
            input.value = input.value;
        });

        document.addEventListener('click', function(event) {
            if (!dropDown.contains(event.target) && !input.contains(event.target)) {
                dropDown.classList.add('d-none');
            }
        });

        input.addEventListener('input', function() {
            let searchValue = input.value.toLowerCase();

            let matchingOptions = 0;
            dropDownUl.querySelectorAll('li').forEach(option => {
                if (option.innerText.toLowerCase().includes(searchValue)) {
                    option.classList.remove('d-none');
                    matchingOptions++;
                } else {
                    option.classList.add('d-none');
                }
            });

            if (matchingOptions === 0) {
                searchMessage.classList.remove('d-none');
            } else {
                searchMessage.classList.add('d-none');
            }

            if (input.value === '') {
                dropDownUl.querySelectorAll('li').forEach(option => {
                    option.classList.add('d-none');
                });
                searchMessage.classList.remove('d-none');
            }
        });

        select.classList.add('d-none');
    }

};
