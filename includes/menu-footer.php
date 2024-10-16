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
        home: document.querySelector('#home'),
        users: document.querySelector('#users'),
        elenchi: document.querySelector('#elenchi'),

        listen: function() {
            const togleListening = () => {
                const closed = this.menuVertical.classList.contains('hide');
                if (closed) {
                    this.menuVertical.classList.remove('hide');
                    this.pageContent.classList.remove('px-2');
                    this.menuDivider.classList.remove('hide');
                    this.menuLabel.forEach(label => label.classList.remove('hide'));
                }
                else {
                    this.menuVertical.classList.add('hide');
                    this.pageContent.classList.add('px-2');
                    this.menuDivider.classList.add('hide');
                    this.menuLabel.forEach(label => label.classList.add('hide'));
                }
            };
            const menuExit = () => {
                document.cookie = "is_logged=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                window.location.href = "index.php";
            };
            const homeClick = () =>{
                window.location.href = "<?php echo url('home.php') ?>";
            }
            const usersClick = () =>{
                window.location.href = "<?php echo url('users.php') ?>";
            }
            const elenchiClick = () =>{
                window.location.href = "<?php echo url('elenchi.php') ?>";
            }
            this.menuIcon.addEventListener('click', togleListening);
            this.menuIconBack.addEventListener('click', togleListening);
            this.exit.addEventListener('click',menuExit);
            this.home.addEventListener('click', homeClick);
            this.users.addEventListener('click', usersClick);
            this.elenchi.addEventListener('click',elenchiClick);
        }
    }
    menu.listen();

</script>
