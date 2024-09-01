function initializeEventHandlers() {
document.addEventListener('DOMContentLoaded', function () {
    const gallery = document.querySelector('.gallery');
    const lightbox = document.querySelector('.lightbox');
    const lightboxImg = lightbox.querySelector('img');
    const lightboxTitle = lightbox.querySelector('h3');
    const lightboxDescription = lightbox.querySelector('p');
    const lightboxClose = lightbox.querySelector('.lightbox-close');

    gallery.addEventListener('click', function (e) {
        const item = e.target.closest('.gallery-item');
        if (item) {
            const src = item.dataset.src;
            const title = item.dataset.title;
            const description = item.dataset.description;
            lightboxImg.src = src;
            lightboxImg.alt = title;
            lightboxTitle.textContent = title;
            lightboxDescription.textContent = description;
            lightbox.style.display = 'flex';
        }
    });

    function closeLightbox() {
        lightbox.style.display = 'none';
    }

    lightboxClose.addEventListener('click', closeLightbox);
    lightbox.addEventListener('click', function (e) {
        if (e.target === lightbox) {
            closeLightbox();
        }
    });

    // Touch swipe to close lightbox with passive event listeners
    let touchstartX = 0;
    let touchendX = 0;

    lightbox.addEventListener('touchstart', e => {
        touchstartX = e.changedTouches[0].screenX;
    }, { passive: true });

    lightbox.addEventListener('touchend', e => {
        touchendX = e.changedTouches[0].screenX;
        handleSwipe();
    }, { passive: true });

    function handleSwipe() {
        if (touchendX < touchstartX) closeLightbox();
    }

    // Handle ESC key to close lightbox
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });
});

}

// If you want the code to run immediately when loaded in a regular way, you can also add:
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeEventHandlers);
} else {
    initializeEventHandlers();
}