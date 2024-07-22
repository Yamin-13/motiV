<main class="secret-container">
    <h2 class="secret-message">Bonjour, <?= ($_SESSION['user']['name']) ?>.</h2>
    <ul class="admin-actions">
        <li><a class="header-link" href="#">Option</a></li>

    </ul>
    <a href="/ctrl/login/logout.php">se deconnecter</a>
</main>