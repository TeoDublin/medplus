                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-body">
                ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                    <button type="button" class="btn btn-primary btn-add">Aggiungi</button>
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
        impostazioni: document.querySelector('#impostazioni'),
        prenota: document.querySelector('#prenota'),
        clienti: document.querySelector('#clienti'),

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
            this.users.addEventListener('click', () => navigate('utenti.php','utenti'));
            this.impostazioni.addEventListener('click', () => navigate('impostazioni.php','impostazioni'));
            this.prenota.addEventListener('click', () => navigate('prenotazioni.php','prenotazioni'));
            this.clienti.addEventListener('click', () => navigate('clienti.php','clienti'));
        }
    }
    menu.start();
    menu.listen();

</script>
