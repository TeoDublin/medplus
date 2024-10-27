<div class="position-absolute" id="calendarContainer">
    <div class="calendar position-absolute pt-4">
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