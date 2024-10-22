<style>
    div.calendar {
        padding: 20px;
        margin: 50px;
        border: solid rgba(var(--base-bg-primary-rgb),0.3) 0.5px;
        border-radius: 5px;
        width: 455px;
        height: 330px;
        background-color: white;
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
</style>
<div class="calendar">
    <h5 id="month-title"></h5>
    <table class="calendar">
        <thead>
            <th>lu</th>
            <th>ma</th>
            <th>me</th>
            <th>gi</th>
            <th>ve</th>
            <th>sa</th>
            <th>do</th>
        </thead>
        <tbody id="calendar-body">
        </tbody>
    </table>
</div>

<script>
    const calendar = {
        currentMonth: new Date().getMonth(),
        currentYear:new Date().getFullYear(),
        currentDay:new Date().getDate(),
        monthNames : ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"],
        monthTitle : document.getElementById("month-title"),
        generateCalendar : function(day, month, year){
            const firstDay = new Date(year, month).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const calendarBody = document.getElementById("calendar-body");
            
            this.monthTitle.textContent = `${this.monthNames[month]} ${year}`;
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
                        }
                        else{
                            cell.classList.add("calendar-in");
                            cell.addEventListener('click',()=>this.changeCurrent(cell));
                        }
                        cell.textContent = date;
                        date++;
                    }
                    row.appendChild(cell);
                }
                
                calendarBody.appendChild(row);

                if (date > daysInMonth) {
                    break;
                }
            }            
        },
        start:function(){
            this.generateCalendar(this.currentDay,this.currentMonth,this.currentYear);
        },
        changeCurrent:function(cell){
            document.querySelector('.calendar-current').classList.remove('calendar-current');
            cell.classList.remove('calendar-in');
            cell.classList.add('calendar-current');
            this.currentDay=cell.textContent;
        }
    };

    
    calendar.start();
</script>

</body>
</html>
