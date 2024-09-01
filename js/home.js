function initializeEventHandlers() {
    const container = document.querySelector('.button-container');
    const button = container.querySelector('.get-started');

    function createParticle() {
        const particle = document.createElement('div');
        particle.className = 'particle';
        const size = Math.random() * 4 + 2;
        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;
        particle.style.left = `${Math.random() * 100}%`;
        particle.style.top = `${Math.random() * 100}%`;
        container.appendChild(particle);

        particle.animate([
            { transform: 'rotate(0deg) translateY(0) scale(1)', opacity: 0.8 },
            { transform: `rotate(${360 + Math.random() * 720}deg) translateY(-150px) scale(0)`, opacity: 0 }
        ], {
            duration: 4000 + Math.random() * 2000,
            easing: 'cubic-bezier(0.4, 0.0, 0.2, 1)',
        });

        setTimeout(() => particle.remove(), 6000);
    }

    function createShootingStar() {
        const star = document.createElement('div');
        star.className = 'shooting-star';
        star.style.left = `${Math.random() * 100}%`;
        star.style.top = `${Math.random() * 100}%`;
        document.body.appendChild(star);

        star.animate([
            { transform: 'translateX(0) translateY(0) rotate(0deg) scale(0.5)', opacity: 1 },
            { transform: 'translateX(300px) translateY(-300px) rotate(45deg) scale(0.1)', opacity: 0 }
        ], {
            duration: 2000 + Math.random() * 1000,
            easing: 'cubic-bezier(0.4, 0.0, 0.2, 1)',
        });

        setTimeout(() => star.remove(), 3000);
    }

    let particleInterval, starInterval;

    button.addEventListener('mouseover', () => {
        particleInterval = setInterval(createParticle, 100);
        starInterval = setInterval(createShootingStar, 1500);
    });

    button.addEventListener('mouseout', () => {
        clearInterval(particleInterval);
        clearInterval(starInterval);
    });
}

