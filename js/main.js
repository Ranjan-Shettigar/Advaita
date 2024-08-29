document.addEventListener('DOMContentLoaded', function () {
    let currentPage = ''; // Declare currentPage variable

    function loadPage(page, css, script, forceReload = false) {
        // Always fetch a fresh version of the page by appending a unique query parameter if forced reload
        const timestamp = forceReload ? `?t=${new Date().getTime()}` : '';
        const pageUrl = `${page}${timestamp}`;

        fetch(pageUrl, { cache: "no-store" }) // Prevent caching
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(data => {
                document.getElementById('load').innerHTML = data;

                // Remove existing dynamic script and style
                document.querySelectorAll('#dynamic-script, #dynamic-style').forEach(el => el.remove());

                // Load new CSS if provided
                if (css) {
                    const style = document.createElement('link');
                    style.id = 'dynamic-style';
                    style.rel = 'stylesheet';
                    style.href = css;
                    document.head.appendChild(style);
                }

                // Load new script if provided
                if (script) {
                    const newScript = document.createElement('script');
                    newScript.id = 'dynamic-script';
                    newScript.src = script;
                    newScript.onload = function () {
                        console.log(script + ' loaded successfully');
                    };
                    document.body.appendChild(newScript);
                }

                // Update the current page if not forcing reload
                if (!forceReload) {
                    currentPage = page;
                }
            })
            .catch(error => {
                console.error('Error loading the page:', error);
                alert('Failed to load content. Please try again later.');
            });
    }

    // JavaScript to add interactivity to the test page

document.addEventListener('DOMContentLoaded', () => {
    const button = document.getElementById('testButton');
    const text = document.getElementById('testText');
    
    button.addEventListener('click', () => {
        text.textContent = 'Button was clicked!';
        text.style.color = 'red';
    });
});


    // Handle "Read more" link clicks
    document.getElementById('load').addEventListener('click', function (e) {
        if (e.target.classList.contains('read-more')) {
            e.preventDefault();
            const pageToLoad = './events/' + e.target.dataset.page; // Set the path for loadmore.html
            loadPage(pageToLoad, './styles/style.css', './js/gallery.js', true); // Force reload
        }
    });

    // Event listeners for navigation
    document.getElementById('home-page').addEventListener('click', function (e) {
        e.preventDefault();
        loadPage('./home.php', './styles/style.css', './js/event.js');
    });
    document.getElementById('nav-home-page').addEventListener('click', function (e) {
        e.preventDefault();
        loadPage('./home.php', './styles/style.css', './js/event.js');
    });

    // Load the home page by default when the page is ready
    loadPage('./home.php', './styles/style.css', undefined);

   

});

