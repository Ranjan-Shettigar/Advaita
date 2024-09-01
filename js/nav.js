document.addEventListener('DOMContentLoaded', function () {
    let currentPage = sessionStorage.getItem('currentPage') || '';

    function loadPage(page, css, script, forceReload = false) {
        const timestamp = forceReload ? `?t=${new Date().getTime()}` : '';
        const pageUrl = `${page}${timestamp}`;

        if (!forceReload && currentPage === page) {
            console.log('Page already loaded: ' + page);
            return;
        }

        fetch(pageUrl, { cache: "no-store" })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.text();
            })
            .then(data => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(data, 'text/html');
                const content = doc.body.innerHTML;

                document.getElementById('load').innerHTML = content;

                document.querySelectorAll('#dynamic-script, #dynamic-style').forEach(el => el.remove());

                if (css) {
                    const style = document.createElement('link');
                    style.id = 'dynamic-style';
                    style.rel = 'stylesheet';
                    style.href = css;
                    document.head.appendChild(style);
                }

                // Load jQuery if it's not already loaded
                if (typeof jQuery === 'undefined') {
                    const jqueryScript = document.createElement('script');
                    jqueryScript.src = 'https://code.jquery.com/jquery-3.6.0.min.js';
                    jqueryScript.onload = function() {
                        executeScripts(doc);
                    };
                    document.head.appendChild(jqueryScript);
                } else {
                    executeScripts(doc);
                }

                sessionStorage.setItem('currentPage', page);
                currentPage = page;
            })
            .catch(error => {
                console.error('Error loading the page:', error);
                alert('Failed to load content. Please try again later.');
            });
    }

    function executeScripts(doc) {
        // Execute inline scripts
        const inlineScripts = doc.querySelectorAll('script:not([src])');
        inlineScripts.forEach(script => {
            eval(script.textContent);
        });

        // Load and execute external scripts
        const externalScripts = doc.querySelectorAll('script[src]');
        let scriptsLoaded = 0;
        externalScripts.forEach(script => {
            const newScript = document.createElement('script');
            newScript.src = script.src;
            newScript.onload = function() {
                scriptsLoaded++;
                if (scriptsLoaded === externalScripts.length) {
                    // All scripts have loaded, now initialize any functions
                    if (typeof initializeEventHandlers === 'function') {
                        initializeEventHandlers();
                    }
                }
            };
            document.body.appendChild(newScript);
        });
    }

    function checkLoginAndLoadProfile(e) {
        e.preventDefault();
        fetch('./auth/check_login.php', {
            method: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
            .then(response => response.json())
            .then(data => {
                if (data.loggedIn) {
                    loadPage('./profile.php', './styles/profile.css', './js/nav.js');
                } else {
                    window.location.href = data.redirect || 'auth/login.php';
                }
            })
            .catch(() => window.location.href = '../');
    }

    function initializeLightbox() {
        const gallery = document.querySelector('.gallery');
        const lightbox = document.querySelector('.lightbox');

        // Ensure both gallery and lightbox exist before proceeding
        if (!gallery || !lightbox) {
            console.log('Gallery or lightbox not found on this page.');
            return;
        }

        const lightboxImg = lightbox.querySelector('img');
        const lightboxTitle = lightbox.querySelector('h3');
        const lightboxDescription = lightbox.querySelector('p');
        const lightboxClose = lightbox.querySelector('.lightbox-close');

        gallery.addEventListener('click', function (e) {
            const item = e.target.closest('.gallery-item');
            if (item) {
                lightboxImg.src = item.dataset.src;
                lightboxImg.alt = item.dataset.title;
                lightboxTitle.textContent = item.dataset.title;
                lightboxDescription.textContent = item.dataset.description;
                lightbox.style.display = 'flex';
            }
        });

        function closeLightbox() {
            lightbox.style.display = 'none';
        }

        lightboxClose.addEventListener('click', closeLightbox);
        lightbox.addEventListener('click', function (e) {
            if (e.target === lightbox) closeLightbox();
        });

        let touchstartX = 0;
        let touchendX = 0;

        lightbox.addEventListener('touchstart', e => {
            touchstartX = e.changedTouches[0].screenX;
        }, { passive: true });

        lightbox.addEventListener('touchend', e => {
            touchendX = e.changedTouches[0].screenX;
            if (touchendX < touchstartX) closeLightbox();
        }, { passive: true });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeLightbox();
        });
    }

    // Handle "Read more" link clicks
    document.getElementById('load').addEventListener('click', function (e) {
        if (e.target.classList.contains('read-more')) {
            e.preventDefault();
            loadPage('./events/' + e.target.dataset.page, './styles/style.css', './js/gallery.js', true);
        }
    });

    document.getElementById('home-page').addEventListener('click', function (e) {
        e.preventDefault();
        loadPage('./home.php', './styles/home.css','./js/home.js');
    });

    document.getElementById('nav-home-page').addEventListener('click', function (e) {
        e.preventDefault();
        loadPage('./home.php', './styles/home.css', './js/home.js');
    });

    document.getElementById('event-page').addEventListener('click', function (e) {
        e.preventDefault();
        loadPage('./events.php', './styles/event.css', './js/main.js', true);
    });

    document.getElementById('nav-event-page').addEventListener('click', function (e) {
        e.preventDefault();
        loadPage('./events.php', './styles/event.css', './js/main.js', true);
    });

    document.getElementById('gallery-page').addEventListener('click', function (e) {
        e.preventDefault();
        loadPage('./gallery.php', './styles/gallery.css', './test.js');
    });

    document.getElementById('nav-gallery-page').addEventListener('click', function (e) {
        e.preventDefault();
        loadPage('./gallery.php', './styles/gallery.css', './test.js');
    });


    document.getElementById('sponsors').addEventListener('click', function (e) {
        e.preventDefault();
        loadPage('./pages/sponsors.html', './pages/css/sponsors.css', './js/main.js', true);
    });

    document.getElementById('contact').addEventListener('click', function (e) {
        e.preventDefault();
        loadPage('./pages/contact.html', './pages/css/contact.css', './test.js');
    });

    document.getElementById('about').addEventListener('click', function (e) {
        e.preventDefault();
        loadPage('./pages/about.html', './pages/css/about.css', './test.js');
    });




    document.getElementById('profile-page').addEventListener('click', checkLoginAndLoadProfile);
    document.getElementById('nav-profile-page').addEventListener('click', checkLoginAndLoadProfile);

    // Load the home page by default when the page is ready
    loadPage('./home.php', './styles/home.css', './js/home.js', true);
});
