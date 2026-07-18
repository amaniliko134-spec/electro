function hidePageLoader() {
    const loader = document.getElementById('page-loader');
    if (!loader) return;
    loader.classList.remove('active');
    document.body.style.pointerEvents = '';
    document.body.style.cursor = '';
    loader.setAttribute('aria-hidden', 'true');
}

function showPageLoader() {
    const loader = document.getElementById('page-loader');
    if (!loader) return;
    loader.classList.add('active');
    document.body.style.pointerEvents = 'none';
    document.body.style.cursor = 'progress';
    loader.setAttribute('aria-hidden', 'false');
}

function navigateWithLoader(url) {
    if (!url) return;
    showPageLoader();
    requestAnimationFrame(() => {
        setTimeout(() => {
            window.location.href = url;
        }, 35);
    });
}

window.addEventListener('load', function() {
    hidePageLoader();
    bindLoaderLinks();
});
window.addEventListener('pageshow', function(event) {
    if (event.persisted) {
        hidePageLoader();
    }
});

function bindLoaderLinks(scope = document) {
    scope.querySelectorAll('a[href]').forEach(link => {
        const href = link.getAttribute('href');
        if (!href || href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('tel:') || href.startsWith('javascript:')) return;
        if (link.target === '_blank' || link.hasAttribute('download')) return;
        if (href.startsWith('/')) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                navigateWithLoader(link.href);
            });
        }
    });

    scope.querySelectorAll('[data-nav-url]').forEach(navItem => {
        navItem.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.getAttribute('data-nav-url');
            if (url) navigateWithLoader(url);
        });
    });
}

window.bindShopLoader = bindLoaderLinks;
