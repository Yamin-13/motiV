window.addEventListener('load', function() {
    const scrollContent = document.querySelector('.scroll-content');

    // Duplique le contenu plusieurs fois pour un effet de défilement infini plus fluide
    const originalContent = scrollContent.innerHTML;
    scrollContent.innerHTML += originalContent + originalContent + originalContent;
});
