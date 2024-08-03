<?php if (isset($_SESSION['invitation'])): ?>
    <?php $invitation = $_SESSION['invitation']; ?>
    <h2>Inscription</h2>
    <form action="/ctrl/invitation/register.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?=($invitation['email']) ?>" readonly><br>
        <label for="name">Nom:</label>
        <input type="text" id="name" name="name" required><br>
        <label for="first_name">Prénom:</label>
        <input type="text" id="first_name" name="first_name" required><br>
        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required><br>
        <button type="submit">S'inscrire</button>
    </form>
<?php else: ?>
    <p>Invitation invalide ou expirée. Veuillez demander une nouvelle invitation.</p>
<?php endif; ?>
