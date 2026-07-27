(() => {
    const menuButton = document.querySelector('.jp-menu-toggle');
    const nav = document.querySelector('.jp-nav');

    if (!menuButton || !nav) return;

    const closeMenu = () => {
        nav.classList.remove('is-open');
        menuButton.setAttribute('aria-expanded', 'false');
    };

    menuButton.addEventListener('click', () => {
        const open = nav.classList.toggle('is-open');
        menuButton.setAttribute('aria-expanded', String(open));
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeMenu();
            menuButton.focus();
        }
    });
})();
