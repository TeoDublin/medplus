
    <div class="position-absolute justify-content-center bg-transparent ">
        <div class="time-picker p-1 col position-relative"> 
            <div class="fixed-top-right p-1 hover-white exit-btn"><?php echo icon('close.svg','black',20,20) ?></div>
            <div class="col hover-white"><button class="btn clean-btn p-1 m-0"><?php echo icon('bin.svg','black',20,30) ?></button></div>
            <div class="col">
                <div class="hover-white p-0 hour-up"><?php echo icon('arrow-filled-up.svg','black','100%',20); ?></div>
                <div class="scroller">
                    <div class="scroll-content hourScroller d-flex justify-content-center h-100"><h1 class="flex-fill align-content-center m-0">00</h1></div>
                </div>
                <div class="hover-white hour-down"><?php echo icon('arrow-filled-down.svg','black','100%',20); ?></div>
            </div>
            <div class="col"><span class="separator">:</span></div>
            <div class="col">
                <div class="hover-white p-0 minute-up"><?php echo icon('arrow-filled-up.svg','black','100%',20); ?></div>
                <div class="scroller">
                    <div class="scroll-content minuteScroller  d-flex justify-content-center h-100"><h1 class="flex-fill align-content-center m-0">00</h1></div>
                </div>
                <div class="hover-white minute-down"><?php echo icon('arrow-filled-down.svg','black','100%',20); ?></div>
            </div>
            <div class="col hover-white"><button class="btn close-btn p-1 m-0"><?php echo icon('check.svg','black',20,30) ?></button></div>
        </div>
    </div>
