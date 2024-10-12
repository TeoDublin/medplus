
<script>
    const menu = {
        menuVertical: document.querySelector('.menu-vertical'),
        pageContent: document.querySelector('.page-content'),
        menuIcon: document.querySelector('.menu-icon'),
        exit: document.querySelector('.menu-exit'),
        setup: document.querySelector('.menu-setup'),

        listen: function() {
            const togleListening = () => {
                const isActive = this.menuIcon.classList.toggle('block');
                if (isActive) {
                    this.menuIcon.classList.add('block');
                    this.menuVertical.classList.add('show');
                }
                else {
                    this.menuIcon.classList.remove('block');
                    this.menuVertical.classList.remove('show');
                }
            };
            const menuExit = () => {
                document.cookie = "is_logged=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                window.location.href = "index.php";
            };
            this.menuIcon.addEventListener('click', togleListening);
            this.exit.addEventListener('click',menuExit);
            this.setup.addEventListener('click',menuSetup);
        }
    }
    menu.listen();

</script>
