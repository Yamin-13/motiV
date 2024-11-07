document.addEventListener('DOMContentLoaded', function () {
    // Initialisation pour cacher les modals au démarrage
    document.querySelectorAll('.qr-modal').forEach(function(modal) {
        modal.style.display = 'none'; // Masquer tous les modals au chargement de la page
    });

    // Gestion de l'affichage du modal lorsque l'image est cliquée
    document.querySelectorAll('.reward-image').forEach(function(img) {
        img.addEventListener('click', function() {
            let code = this.getAttribute('data-code');
            let modal = document.getElementById('qrModal-' + code);
            if (modal) {
                modal.style.display = 'flex'; // Affiche le modal uniquement au clic
            }
        });
    });

    // Gestion de la fermeture du modal en cliquant sur le QR code
    document.querySelectorAll('.modal-content').forEach(function(modalContent) {
        modalContent.addEventListener('click', function() {
            let modal = this.closest('.qr-modal');
            if (modal) {
                modal.style.display = 'none'; // Masque le modal
            }
        });
    });

    // Gestion de la fermeture du modal en cliquant en dehors du QR code
    window.addEventListener('click', function(event) {
        if (event.target.classList.contains('qr-modal')) {
            event.target.style.display = 'none'; // Masque le modal
        }
    });
});