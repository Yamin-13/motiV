// scrollreveal

// Fonction pour détecter si un élément est visible dans la fenêtre
function isElementInViewport(el) {
    let rect = el.getBoundingClientRect();
    return (
        rect.top <= (window.innerHeight || document.documentElement.clientHeight)
    );
}

// Fonction pour ajouter la classe active au éléments en vue
function revealElements() {
    let reveals = document.querySelectorAll('.scroll-reveal');
    reveals.forEach(function (el) {
        if (isElementInViewport(el)) {
            el.classList.add('active');
        }
    });
}

// Événement au scroll et au chargement de la page
window.addEventListener('scroll', revealElements);
window.addEventListener('load', revealElements);


window.addEventListener('load', function() {
    let scrollContent = document.querySelector('.scroll-content');
    let scrollContainer = document.querySelector('.scroll-container');

    // Vérifie si la duplication est déjà effectué avant d'ajouter des éléments supplémentaire
    if (scrollContent.childElementCount < 12) {
        // Duplique le contenu de la section défilement pour l'effet continu
        scrollContent.innerHTML += scrollContent.innerHTML;
    }
    
    // Calcul de la largeur totale du défilement
    let scrollWidth = 0;
    document.querySelectorAll('.scroll-content img').forEach(img => {
        scrollWidth += img.offsetWidth;
    });

    scrollContent.style.width = `${scrollWidth}px`;
});


//  gére l'animation au scroll pour les missions
document.addEventListener("DOMContentLoaded", function() {
    let missionItems = document.querySelectorAll('.mission-item');

    // Observer pour l'animation d'apparition
    let observerOptions = {
        root: null,
        rootMargin: "0px",
        threshold: 0.2
    };

    let observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible'); // Ajoute la classe qui rend visible l'élément
                observer.unobserve(entry.target); // Une fois visible, on arrête l'observation
            }
        });
    }, observerOptions);

    missionItems.forEach(item => {
        observer.observe(item);
    });
});