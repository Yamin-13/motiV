// scrollreveal ---------------

// Fonction pour détecté si un élément est visible dans la fenêtre
function isElementInViewport(el) {
    let rect = el.getBoundingClientRect();
    return (
        rect.top <= (window.innerHeight || document.documentElement.clientHeight)
    );
}

// fonction pour ajouté la classe active au éléments en vue
function revealElements() {
    let reveals = document.querySelectorAll('.scroll-reveal');
    reveals.forEach(function (el) {
        if (isElementInViewport(el)) {
            el.classList.add('active');
        }
    });
}

// événement au scroll et au chargement de la page
window.addEventListener('scroll', revealElements);
window.addEventListener('load', revealElements);

//  gére l'animation au scroll pour les missions
document.addEventListener("DOMContentLoaded", function() {
    let missionItems = document.querySelectorAll('.mission-item');

    // Observe pour l'animation d'apparition
    let observerOptions = {
        root: null,
        rootMargin: "0px",
        threshold: 0.2
    };

    let observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible'); // ca ajoute la classe qui rend visible l'élément
                observer.unobserve(entry.target); // une fois visible on arrete l'observation
            }
        });
    }, observerOptions);

    missionItems.forEach(item => {
        observer.observe(item);
    });
});