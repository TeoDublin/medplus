    </div>
</div>
<script>
    const menu = {
        menuVertical: document.querySelector('.menu-vertical'),
        pageContent: document.querySelector('.page-content'),
        menuIcon: document.querySelector('.menu-icon'),
        
        listen: function() {
            const mouseOverIcon = () => {
                if(!this.menuIcon.classList.contains('block')){
                    this.menuIcon.classList.add('hover');
                    this.menuVertical.classList.add('show');
                }
            };

            const mouseOverContent = () => {
                if(!this.menuIcon.classList.contains('block')){
                    this.menuIcon.classList.remove('hover');
                    this.menuVertical.classList.remove('show');
                }
            };

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

            this.menuIcon.addEventListener('mouseover', mouseOverIcon);
            this.pageContent.addEventListener('mouseover', mouseOverContent);
            this.menuIcon.addEventListener('click', togleListening);
        }
    }
    menu.listen();

</script>
