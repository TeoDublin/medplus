const hourPicker = {
    start(_target){
        this.target=_target;
        this.now=new Date();
        this.currentHour=this.now.getHours();
        this.currentMinute=this.now.getMinutes();
        this.container=document.querySelector('#hourPicker');
        this.hourScroller = document.querySelector(".hourScroller");
        this.minuteScroller = document.querySelector(".minuteScroller");
        this.selectedTime = document.getElementById("selectedTime");
        this.value=document.querySelector(_target);
        this.hours=this.createOptions(0, 23, 1);
        this.createHtml(this.hourScroller,this.hours,8,'hour');
        this.enableScrollOnHover(this.hourScroller,this.hours,'hour');
        this.minutes=this.createOptions(0, 45, 15);
        this.createHtml(this.minuteScroller,this.minutes,0,'minute');
        this.enableScrollOnHover(this.minuteScroller,this.minutes,'minute');
        this.closeBtn=document.querySelector('.close-btn');
        this.closeBtn.addEventListener('click',this.close.bind(this));
        document.querySelector('.clean-btn').addEventListener('click',this.clean.bind(this));
    },
    close(){
        this.container.remove();
    },
    clean(){
        this.value.value='';
        this.container.remove();
    },
    createOptions(start, end, step) {
        let ret=[];
        for (let i = start; i <= end; i=i+step) {
            ret.push(i.toString().padStart(2, "0"));
        }
        return ret;
    },
    createHtml(container, arrayList, setValue, controller){
        let h1 = container.querySelector('h1');
        if(arrayList[setValue]){
            h1.innerHTML = arrayList[setValue];
            switch (controller) {
                case 'hour':
                    this.currentHour=arrayList[setValue];
                    break;
                case 'minute':
                    this.currentMinute=arrayList[setValue];
                    break;
            }
            controller=setValue;
            h1.setAttribute('index',setValue);
            this.valueUpdate();
        }
    },
    enableScrollOnHover(container, arrayList, controller) {
        container.addEventListener("wheel", (e) => {
            e.preventDefault();
            let index = Number(container.querySelector('h1').getAttribute('index'));
            let next = e.deltaY > 0 ? index - 1 : index + 1;
            this.createHtml(container, arrayList, next, controller);
        });
        let startY = 0;
        container.addEventListener("touchstart", (e) => {
            startY = e.touches[0].clientY;
        });
        container.addEventListener("touchmove", (e) => {
            e.preventDefault();
            let index = Number(container.querySelector('h1').getAttribute('index'));
            let moveY = e.touches[0].clientY;
            let deltaY = startY - moveY;
            if (Math.abs(deltaY) > 30) {
                let next = deltaY > 0 ? index + 1 : index - 1;
                this.createHtml(container, arrayList, next, controller);
                startY = moveY;
            }
        });
    },    
    valueUpdate(){
        this.value.value=`${this.currentHour}:${this.currentMinute}`;
    }
}