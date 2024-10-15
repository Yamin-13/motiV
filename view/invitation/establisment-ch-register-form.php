<h2>Inscription via Invitation</h2>

<!-- Vérifie si ya des message d'erreur dans la session -->
<?php if (isset($_SESSION['error'])) : ?>
    <div class="error-message">
        <?= $_SESSION['error'] ?>
        <?php unset($_SESSION['error']); // Supprime le message apres affichage ?>
    </div>
<?php endif; ?>

<!-- Formulaire d'inscription -->
<form action="/ctrl/invitation/register-process.php" method="post">
    <label for="email">Email :</label>
    <input type="email" id="email" name="email" 
           value="<?= isset($_SESSION['form_data']['email']) ? $_SESSION['form_data']['email'] : (isset($_SESSION['invitation']['email']) ? $_SESSION['invitation']['email'] : '') ?>" 
           readonly><br>

    <label for="name">Nom :</label>
    <input type="text" id="name" name="name" 
           value="<?= $_SESSION['form_data']['name'] ?? '' ?>" required><br>

    <label for="first_name">Prénom :</label>
    <input type="text" id="first_name" name="first_name" 
           value="<?= $_SESSION['form_data']['first_name'] ?? '' ?>" required><br>

    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" required><br>

    <label for="confirm_password">Confirmer le mot de passe :</label>
    <input type="password" id="confirm_password" name="confirm_password" required><br>

    <button type="submit">S'inscrire</button>
</form>