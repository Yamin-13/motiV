// sélectionne les élément
let burger = document.querySelector('.burger'); // selecteur du bouton burger
let menuBurger = document.querySelector('.menu-burger-hidden ul'); // selecteur du menu burger
let pointsDisplay = document.querySelector('.points-display'); // selecteur de l'afichage des points

// Ajoute un évenement au clic sur le bouton burger
burger.addEventListener('click', function () {
    // Bascule la classe active pour affiché ou masquer le menu
    menuBurger.classList.toggle('active');
    burger.classList.toggle('active');

    // Masque les point lorsque le menu est ouvert
    if (burger.classList.contains('active')) {
        pointsDisplay.style.display = 'none';
    } else {
        pointsDisplay.style.display = 'flex'; // réaffiche les point lorsque le menu est fermer
    }
});