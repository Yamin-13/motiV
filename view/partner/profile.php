<main class="secret-container">
    <h2 class="secret-message">Bonjour, Partenaire <?= ($_SESSION['user']['name']) ?>.</h2>
    <ul class="admin-actions">
        <li><a class="header-link" href="/ctrl/register/display-register-partner.php">Ajouter un partenaire</a></li>

    </ul>
    <a href="/ctrl/login/logout.php">se deconnecter</a>
</main>