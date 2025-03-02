                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal"></div>
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
        terapisti: document.querySelector('#menu-terapisti'),
        prenota: document.querySelector('#menu-prenota'),
        clienti: document.querySelector('#menu-clienti'),
        utenti: document.querySelector('#menu-utenti'),
        pagamenti: document.querySelector('#menu-pagamenti'),
        trattamenti: document.querySelector('#menu-trattamenti'),
        corsi: document.querySelector('#menu-corsi'),
        start: function(){
            if(getCookie("menu")=="show"){
                this.menuVertical.classList.remove('hide');
                this.menuDivider.classList.remove('hide');
                this.menuLabel.forEach(label => label.classList.remove('hide'));
                this.pageContent.classList.remove('menu-hidden');
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
                    this.pageContent.classList.remove('menu-hidden');
                }
                else {
                    setCookie("menu", "hide", 365);
                    this.menuVertical.classList.add('hide');
                    this.menuDivider.classList.add('hide');
                    this.menuLabel.forEach(label => label.classList.add('hide'));
                    this.pageContent.classList.add('menu-hidden');
                }
            };
            const menuExit = () => {
                $.post('post/logout.php').done(()=>{
                    window.location.href = "index.php";
                }).fail(()=>{fail();});
            };
            const navigate = (page, menu)=>{
                window.location.href = "<?php echo url('') ?>"+page+"?pagination=0&unset=tab&menu_page="+menu;
            }
            this.menuIcon.addEventListener('click', togleListening);
            this.menuIconBack.addEventListener('click', togleListening);
            this.exit.addEventListener('click',menuExit);<?php
            if(in_array('menu_prenotazioni',$elementi)){?>
                this.prenota.addEventListener('click', () => navigate('prenotazioni.php','prenotazioni'));<?php
            }
            if(in_array('menu_pagamenti',$elementi)){?>
                this.pagamenti.addEventListener('click', () => navigate('pagamenti.php','pagamenti'));<?php
            }
            if(in_array('menu_terapisti',$elementi)){?>
                this.terapisti.addEventListener('click', () => navigate('terapisti.php','terapisti'));<?php
            }
            if(in_array('menu_clienti',$elementi)){?>
                this.clienti.addEventListener('click', () => navigate('clienti.php','clienti'));<?php
            }
            if(in_array('menu_utenti',$elementi)){?>
                this.utenti.addEventListener('click', () => navigate('utenti.php','utenti'));<?php
            }
            if(in_array('menu_trattamenti',$elementi)){?>
                this.trattamenti.addEventListener('click', () => navigate('trattamenti.php','trattamenti'));<?php
            }
            if(in_array('menu_corsi',$elementi)){?>
                this.corsi.addEventListener('click', () => navigate('corsi.php','corsi'));<?php
            }?>
        }
    }
    menu.start();
    menu.listen();

</script>
