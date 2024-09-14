// sélectionne les élément
let burger = document.querySelector('.burger'); // Sélecteur du bouton burger
let menuBurger = document.querySelector('.menu-burger-hidden ul'); // Sélecteur du menu burger
let pointsDisplay = document.querySelector('.points-display'); // Sélecteur de l'afichage des points

// Ajoute un événement au clic sur le bouton burger
burger.addEventListener('click', function () {
    // Bascule la classe active pour afficher ou masquer le menu
    menuBurger.classList.toggle('active');
    burger.classList.toggle('active');

    // Masque les point lorsque le menu est ouvert
    if (burger.classList.contains('active')) {
        pointsDisplay.style.display = 'none';
    } else {
        pointsDisplay.style.display = 'flex'; // réaffiche les points lorsque le menu est fermé
    }
});