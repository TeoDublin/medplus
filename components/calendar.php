<style>
    div.calendar {
        padding: 20px;
        border: solid rgba(var(--base-bg-primary-rgb),0.3) 0.5px;
        border-radius: 5px;
        background-color: white;
        width: 455px;
    }
    table.calendar td,th {
        line-height: 40px;
        padding-inline: 20px;
        border-bottom: solid rgba(var(--base-bg-primary-rgb),0.2) 0.2px;
    }
    td.calendar-out{
        background-color: rgba(var(--base-bg-primary-rgb),0.04);
    }
    td.calendar-in{
        background-color: transparent;
    }
    td.calendar-in:hover{
        background-color: rgba(var(--base-bg-primary-rgb),0.2);
        border-radius: 50%;
        cursor:pointer;
    }
    td.calendar-current{
        background-color: rgba(var(--base-bg-primary-rgb),0.2);
        border-radius: 50%;
    }
    .year-title:hover, .month-title:hover{
        cursor:pointer;
        background-color: rgba(var(--base-bg-primary-rgb),0.2);
        border-radius: 5px;        
    }
</style>
<div class="position-relative" id="<?php echo $params['id'];?>" hidden>
    <div class="calendar position-absolute <?php echo $params['container-class']??'start-50 translate-middle-x';?> pt-4">
        <button class="btn close-btn position-absolute end-0 top-0 p-1 m-0"><?php echo icon('close.svg','var(--base-bg-primary)',30,30) ?></button>
        <div class="d-flex flex-row">
            <div class="btn-group dropend">
                <h5 class="p-2 me-2 month-title" role="button" data-bs-toggle="dropdown"></h5>
                <div id="monthDropdown"><ul class="dropdown-menu"></ul></div>
            </div>  
            <div class="btn-group dropend">   
                <h5 class="p-2 year-title" role="button" data-bs-toggle="dropdown"></h5>
                <div id="yearDropdown"><ul class="dropdown-menu"></ul></div>
            </div>
        </div>
        <table class="calendar">
            <thead><th>lu</th><th>ma</th><th>me</th><th>gi</th><th>ve</th><th>sa</th><th>do</th></thead>
            <tbody id="calendar-body"></tbody>
        </table>
    </div>
</div>
<script>
    const calendar_<?php echo $params['id'];?> = {
        currentMonth: new Date().getMonth(),
        currentYear:new Date().getFullYear(),
        currentDay:new Date().getDate(),
        monthNames : ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"],
        monthDropdownOptions:null,
        yearDropdownOptions:null,
        generateCalendar : function(day, month, year){
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
                        if(date==day){
                            cell.classList.add("calendar-current");
                            cell.addEventListener('click',()=>this.changeCurrentDay(cell));
                        }
                        else{
                            cell.classList.add("calendar-in");
                            cell.addEventListener('click',()=>this.changeCurrentDay(cell));
                        }
                        cell.textContent = date;
                        date++;
                    }
                    row.appendChild(cell);
                }
                calendarBody.appendChild(row);
                if (date > daysInMonth) { break;}
            }
            this.calendarValueUpdate();
        },
        start:function(){
            this.calendarContainer=document.querySelector('div#<?php echo $params['id'];?>');
            this.closeBtn=this.calendarContainer.querySelector('.close-btn');
            this.calendarValue=document.querySelector('<?php echo $params['destination'];?>');
            this.monthTitle=this.calendarContainer.querySelector('.month-title');
            this.monthDropdown=this.calendarContainer.querySelector('#monthDropdown > ul');
            this.yearDropdown=this.calendarContainer.querySelector('#yearDropdown > ul');
            this.yearTitle=this.calendarContainer.querySelector('.year-title');
            this.toggleElement=document.querySelector('<?php echo $params['toggleElement'];?>');      
            this.monthDropdown.innerHTML = this.monthNames.map(
                (name,index)=>`<li month=${index} class="monthOption"><a class="dropdown-item ${index === this.currentMonth ? 'active' : ''}"" href="#">${name}</a></li>`
            ).join('');
            this.monthDropdownOptions=this.calendarContainer.querySelectorAll('.monthOption');
            this.monthDropdownOptions.forEach((element)=>{element.addEventListener('click',()=>this.updateMonth(element))});
            let yearList = [];
            for(let i=this.currentYear-1;i<this.currentYear+2;i++){ yearList.push(i);}
            this.yearDropdown.innerHTML = yearList.map(
                (year)=>`<li year=${year} class="yearOption"><a class="dropdown-item ${year === this.currentYear ? 'active' : ''}"" href="#">${year}</a></li>`
            ).join('');
            this.yearDropdownOptions=this.calendarContainer.querySelectorAll('.yearOption');
            this.yearDropdownOptions.forEach((element)=>{element.addEventListener('click',()=>this.updateYear(element))});            
            this.generateCalendar(this.currentDay,this.currentMonth,this.currentYear);
            this.closeBtn.addEventListener('click',this.closeContainer());
            this.toggleElement.addEventListener('click',()=>{this.calendarContainer.removeAttribute('hidden')});
        },
        closeContainer:function(){this.calendarContainer.setAttribute('hidden','')},
        changeCurrentDay:function(cell){
            this.calendarCurrent();
            cell.classList.remove('calendar-in');
            cell.classList.add('calendar-current');
            this.currentDay=cell.textContent;
            this.calendarValueUpdate();
            this.closeContainer();
        },
        changeCurrentMonth:function(month){
            this.currentMonth=month;
            this.generateCalendar(this.currentDay,this.currentMonth,this.currentYear);
        },
        changeCurrentYear:function(year){
            this.currentYear=year;
            this.generateCalendar(this.currentDay,this.currentMonth,this.currentYear);
        },        
        updateMonth:function(element){
            let active=this.calendarContainer.querySelector('.monthOption > .active');
            if(active){ active.classList.remove('active');}
            element.querySelector('a').classList.add('active');
            this.changeCurrentMonth(element.getAttribute('month'));
        },
        updateYear:function(element){
            this.calendarContainer.querySelector('.yearOption > .active').classList.remove('active');
            element.querySelector('a').classList.add('active');
            this.changeCurrentYear(element.getAttribute('year'));
            this.calendarCurrent();
        },
        calendarValueUpdate:function(){
            this.calendarValue.setAttribute('value',`${String(this.currentDay).padStart(2,0)}/${String(Number(this.currentMonth)+1).padStart(2,0)}/${this.currentYear}`);
            this.calendarValue.setAttribute('date',`${this.currentYear}-${String(Number(this.currentMonth)+1).padStart(2,0)}-${String(this.currentDay).padStart(2,0)}`);
        },
        calendarCurrent:function(){
            let calendarCurrent=this.calendarContainer.querySelector('.calendar-current');
            if(calendarCurrent){ 
                calendarCurrent.classList.remove('calendar-current');
                calendarCurrent.classList.add('calendar-in');
            }
        }
    };
    document.addEventListener("DOMContentLoaded", () => { calendar_<?php echo $params['id'];?>.start();});
</script>