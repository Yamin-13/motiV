// reward.js

// Fonction pour détecter si un élément est visible dans la fenêtre
function isElementInViewport(el) {
    let rect = el.getBoundingClientRect();
    return (
        rect.top <= (window.innerHeight || document.documentElement.clientHeight)
    );
}

// Fonction pour ajouter la classe 'active' aux éléments en vue
function revealElements() {
    let reveals = document.querySelectorAll('.scroll-reveal');
    reveals.forEach(function (el) {
        if (isElementInViewport(el)) {
            el.classList.add('active');
        }
    });
}

// Événements au scroll et au chargement de la page
window.addEventListener('scroll', revealElements);
window.addEventListener('load', revealElements);

// Exemple d'interaction pour le bouton 'Ajouter au panier'
document.addEventListener('DOMContentLoaded', function() {
    let addToCartButtons = document.querySelectorAll('.action-button');

    addToCartButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            // Vous pouvez ajouter ici une logique supplémentaire si nécessaire
            alert('Récompense ajoutée au panier !');
        });
    });
});
