                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const menu = {
        menuVertical: document.querySelector('.menu-vertical'),
        pageContent: document.querySelector('.page-content'),
        menuDivider: document.querySelector('.menu-divider'),
        menuIconBack: document.querySelector('.menu-icon-back'),
        menuIcon: document.querySelector('.menu-icon'),
        menuLabel: document.querySelectorAll('.menu-label'),
        exit: document.querySelector('.menu-exit'),
        setup: document.querySelector('.menu-setup'),
        users: document.querySelector('#users'),
        impostazioni: document.querySelector('#menu-impostazioni'),
        prenota: document.querySelector('#menu-prenota'),
        clienti: document.querySelector('#menu-clienti'),
        fattura: document.querySelector('#menu-fattura'),
        start: function(){
            if(getCookie("menu")=="show"){
                this.menuVertical.classList.remove('hide');
                this.menuDivider.classList.remove('hide');
                this.menuLabel.forEach(label => label.classList.remove('hide'));
            }
        },
        listen: function() {
            const togleListening = () => {
                const closed = this.menuVertical.classList.contains('hide');
                if (closed) {
                    setCookie("menu", "show", 365);
                    this.menuVertical.classList.remove('hide');
                    this.menuDivider.classList.remove('hide');
                    this.menuLabel.forEach(label => label.classList.remove('hide'));
                }
                else {
                    setCookie("menu", "hide", 365);
                    this.menuVertical.classList.add('hide');
                    this.menuDivider.classList.add('hide');
                    this.menuLabel.forEach(label => label.classList.add('hide'));
                }
            };
            const menuExit = () => {
                document.cookie = "is_logged=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                window.location.href = "index.php";
            };
            const navigate = (page, menu)=>{
                window.location.href = "<?php echo url('') ?>"+page+"?pagination=0&openModal=unset&rowId=unset&unset=tab&menu="+menu;
            }
            this.menuIcon.addEventListener('click', togleListening);
            this.menuIconBack.addEventListener('click', togleListening);
            this.exit.addEventListener('click',menuExit);
            this.impostazioni.addEventListener('click', () => navigate('impostazioni.php','impostazioni'));
            this.prenota.addEventListener('click', () => navigate('prenotazioni.php','prenotazioni'));
            this.fattura.addEventListener('click', () => navigate('fattura.php','fattura'));
            this.clienti.addEventListener('click', () => navigate('clienti.php','clienti'));
        }
    }
    menu.start();
    menu.listen();

</script>
