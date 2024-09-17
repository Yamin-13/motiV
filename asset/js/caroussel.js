// caroussel de la page home
document.addEventListener('DOMContentLoaded', function() {
    // fonction pour initialiser le carrousel
    function initCarousel(carouselId, prevBtnId, nextBtnId) {
        let carousel = document.getElementById(carouselId);
        let prevBtn = document.getElementById(prevBtnId);
        let nextBtn = document.getElementById(nextBtnId);
        let currentIndex = 0;
        let totalItems = carousel.children.length;
        let itemWidth = carousel.children[0].offsetWidth;

        // Fonction pour mettre à jour la position du carrousel
        function updateCarousel() {
            carousel.style.transform = `translateX(-${currentIndex * itemWidth}px)`;
        }

        // evénement pour le bouton précédent
        prevBtn.addEventListener('click', function() {
            if (currentIndex > 0) {
                currentIndex--;
                updateCarousel();
            }
        });

        // evénement pour le bouton suivant
        nextBtn.addEventListener('click', function() {
            if (currentIndex < totalItems - 1) {
                currentIndex++;
                updateCarousel();
            }
        });

        // Gestion du redimensionnement de la fenêtre
        window.addEventListener('resize', function() {
            // recalcul la largeur des éléments
            let newItemWidth = carousel.children[0].offsetWidth;
            carousel.style.transition = 'none'; // désactive la trasition pendant le recalcul
            carousel.style.transform = `translateX(-${currentIndex * newItemWidth}px)`;
            setTimeout(() => {
                carousel.style.transition = 'transform 0.3s ease-in-out';
            }, 0);
        });

        // Gestion du défilement tactile pour mobile
        let startX = 0;
        let isDragging = false;

        carousel.addEventListener('touchstart', function(e) {
            startX = e.touches[0].clientX;
            isDragging = true;
        });

        carousel.addEventListener('touchmove', function(e) {
            if (!isDragging) return;
            let currentX = e.touches[0].clientX;
            let diffX = currentX - startX;
        });

        carousel.addEventListener('touchend', function(e) {
            if (!isDragging) return;
            let endX = e.changedTouches[0].clientX;
            let diffX = endX - startX;
            if (diffX > 50 && currentIndex > 0) {
                // Swipe vers la droite
                currentIndex--;
            } else if (diffX < -50 && currentIndex < totalItems - 1) {
                // Swipe vers la gauche
                currentIndex++;
            }
            updateCarousel();
            isDragging = false;
        });
    }

    // Initialise les carrousel
    initCarousel('rewards-carousel', 'rewards-prev', 'rewards-next');
    initCarousel('missions-carousel', 'missions-prev', 'missions-next');
});
