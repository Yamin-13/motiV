<main class="secret-container">
    <h2 class="secret-message">Bonjour, Président <?= ($_SESSION['user']['name']) ?>.</h2>
    <ul class="admin-actions">
        <li><a class="header-link" href="/ctrl/register/display-register-association.php">Ajouter une association</a></li>

    </ul>
    <a href="/ctrl/login/logout.php">se deconnecter</a>
</main>