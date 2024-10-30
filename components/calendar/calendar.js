const calendar = {
    currentMonth: (getCookie('currentMonth')) ? getCookie('currentMonth') : new Date().getMonth(),
    currentYear: (getCookie('currentYear')) ? getCookie('currentYear') : new Date().getFullYear(),
    currentDay: (getCookie('currentDay')) ? getCookie('currentDay') : new Date().getDate(),
    monthNames: ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"],
    monthDropdownOptions: null,
    yearDropdownOptions: null,
    start(_target, _left, _top) {
        this.targetValue = document.querySelector(_target);
        this.calendarContainer = document.querySelector('div#calendarContainer');
        this.calendarContainer.setAttribute('style', `left: ${_left}px; top: ${_top}px;`);
        this.closeBtn = this.calendarContainer.querySelector('.close-btn');
        this.monthTitle = this.calendarContainer.querySelector('.month-title');
        this.monthDropdown = this.calendarContainer.querySelector('#monthDropdown > ul');
        this.yearDropdown = this.calendarContainer.querySelector('#yearDropdown > ul');
        this.yearTitle = this.calendarContainer.querySelector('.year-title');
        
        this.monthDropdown.innerHTML = this.monthNames.map((name, index) => 
            `<li month=${index} class="monthOption"><a class="dropdown-item ${index === this.currentMonth ? 'active' : ''}" href="#">${name}</a></li>`
        ).join('');
        
        this.monthDropdownOptions = this.calendarContainer.querySelectorAll('.monthOption');
        this.monthDropdownOptions.forEach((element) => { element.addEventListener('click', () => this.updateMonth(element)) });

        let yearList = [];
        for (let i = this.currentYear - 1; i < this.currentYear + 2; i++) { 
            yearList.push(i); 
        }
        this.yearDropdown.innerHTML = yearList.map(year => 
            `<li year=${year} class="yearOption"><a class="dropdown-item ${year === this.currentYear ? 'active' : ''}" href="#">${year}</a></li>`
        ).join('');
        
        this.yearDropdownOptions = this.calendarContainer.querySelectorAll('.yearOption');
        this.yearDropdownOptions.forEach((element) => { element.addEventListener('click', () => this.updateYear(element)) });
        this.closeBtn.addEventListener('click', this.closeContainer.bind(this));

        this.generateCalendar(this.currentDay, this.currentMonth, this.currentYear);
    },
    generateCalendar(day, month, year) {
        const firstDay = new Date(year, month).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const calendarBody = this.calendarContainer.querySelector("#calendar-body");
        this.monthTitle.textContent = `${this.monthNames[month]}`;
        this.yearTitle.textContent = `${year}`;
        calendarBody.innerHTML = "";
        let date = 1;
        let startDay = firstDay === 0 ? 6 : firstDay - 1;

        for (let i = 0; i < 6; i++) {
            let row = document.createElement("tr");
            for (let j = 0; j < 7; j++) {
                let cell = document.createElement("td");
                if (i === 0 && j < startDay) {
                    cell.classList.add("calendar-out"); 
                } else if (date > daysInMonth) {
                    cell.classList.add("calendar-out");
                } else {
                    if (date == day) {
                        cell.classList.add("calendar-current");
                        cell.addEventListener('click', () => this.changeCurrentDay(cell));
                    } else {
                        cell.classList.add("calendar-in");
                        cell.addEventListener('click', () => this.changeCurrentDay(cell));
                    }
                    cell.textContent = date;
                    date++;
                }
                row.appendChild(cell);
            }
            calendarBody.appendChild(row);
            if (date > daysInMonth) { break; }
        }
        this.calendarValueUpdate();
    },
    closeContainer() { 
        this.calendarContainer.remove(); 
    },
    changeCurrentDay(cell) {
        this.calendarCurrentFn();
        cell.classList.remove('calendar-in');
        cell.classList.add('calendar-current');
        this.currentDay = cell.textContent;
        this.calendarValueUpdate();
        this.closeContainer();
    },
    changeCurrentMonth(month) {
        this.currentMonth = month;
        this.generateCalendar(this.currentDay, this.currentMonth, this.currentYear);
    },
    changeCurrentYear(year) {
        this.currentYear = year;
        this.generateCalendar(this.currentDay, this.currentMonth, this.currentYear);
    },        
    updateMonth(element) {
        let active = this.calendarContainer.querySelector('.monthOption > .active');
        if (active) { 
            active.classList.remove('active'); 
        }
        element.querySelector('a').classList.add('active');
        this.changeCurrentMonth(element.getAttribute('month'));
    },
    updateYear(element) {
        this.calendarContainer.querySelector('.yearOption > .active').classList.remove('active');
        element.querySelector('a').classList.add('active');
        this.changeCurrentYear(element.getAttribute('year'));
        this.calendarCurrentFn();
    },
    calendarValueUpdate() {
        this.targetValue.setAttribute('value', `${String(this.currentDay).padStart(2, '0')}/${String(Number(this.currentMonth) + 1).padStart(2, '0')}/${this.currentYear}`);
    },
    calendarCurrentFn() {
        let calendarCurrent = this.calendarContainer.querySelector('.calendar-current');
        if (calendarCurrent) { 
            calendarCurrent.classList.remove('calendar-current');
            calendarCurrent.classList.add('calendar-in');
        }
    }
};