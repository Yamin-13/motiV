// Script pour gérer l'affichage du modal QR Code dans la page "mes codes"
document.querySelectorAll('.reward-image').forEach(function(img) {
    img.addEventListener('click', function() {
        let code = this.getAttribute('data-code');
        document.getElementById('qrModal-' + code).style.display = 'block';
    });
});

document.querySelectorAll('.close').forEach(function(span) {
    span.addEventListener('click', function() {
        let code = this.getAttribute('data-code');
        document.getElementById('qrModal-' + code).style.display = 'none';
    });
});