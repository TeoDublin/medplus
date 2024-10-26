<style>
    body {
        font-family: Arial, sans-serif;
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 50px;
    }
    .time-picker {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .scroller {
        width: 80px;
        height: 50px;
        overflow-y: auto;
        scroll-behavior: smooth;
        overflow-y: hidden;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 8px;
    }

    .scroll-content div {
        padding: 10px;
        font-size: 1.5em;
    }

    .scroll-content div.selected {
        background-color: #007bff;
        color: #fff;
        border-radius: 4px;
    }

    .separator {
        font-size: 2em;
    }
</style>
<div class="position-relative" id="<?php echo $params['id'];?>">
    <div class="time-picker position-absolute <?php echo $params['container-class']??'start-50 translate-middle-x';?> pt-4">
        <div class="scroller">
            <div class="scroll-content hourScroller d-flex justify-content-center h-100"><h1 class="flex-fill align-content-center m-0">00</h1></div>
        </div>
        <span class="separator">:</span>
        <div class="scroller">
            <div class="scroll-content minuteScroller  d-flex justify-content-center h-100"><h1 class="flex-fill align-content-center m-0">00</h1></div>
        </div>
    </div>
</div>

<script>
    const hourPicker_<?php echo $params['id'];?> = {
        start:function(){
            this.now=new Date();
            this.currentHour=this.now.getHours();
            this.currentMinute=this.now.getMinutes();
            this.hourScroller = document.querySelector(".hourScroller");
            this.minuteScroller = document.querySelector(".minuteScroller");
            this.selectedTime = document.getElementById("selectedTime");
            this.value=document.querySelector('<?php echo $params['destination'];?>');
            this.hours=this.createOptions(0, 23, 1);
            this.createHtml(this.hourScroller,this.hours,8,'hour');
            this.enableScrollOnHover(this.hourScroller,this.hours,'hour');
            this.minutes=this.createOptions(0, 45, 15);
            this.createHtml(this.minuteScroller,this.minutes,0,'minute');
            this.enableScrollOnHover(this.minuteScroller,this.minutes,'minute');
        },
        createOptions:function(start, end, step) {
            let ret=[];
            for (let i = start; i <= end; i=i+step) {
                ret.push(i.toString().padStart(2, "0"));
            }
            return ret;
        },
        createHtml:function(container, arrayList, setValue, controller){
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
        enableScrollOnHover:function(container,arrayList,controller) {
            container.addEventListener("wheel", (e) => {
                e.preventDefault();
                let index = Number(container.querySelector('h1').getAttribute('index'));
                let next = e.deltaY > 0 ? index+1 : index-1;
                this.createHtml(container,arrayList,next,controller);
            });
        },
        valueUpdate:function(){
            this.value.value=`${this.currentHour}:${this.currentMinute}`;
        }
    };
    document.addEventListener("DOMContentLoaded", () => { hourPicker_<?php echo $params['id'];?>.start();});
</script>