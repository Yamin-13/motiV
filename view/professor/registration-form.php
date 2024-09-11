<h1>Inscription Professeur</h1>
<form action="/ctrl/professor/register.php" method="POST">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>
    <label for="name">Nom:</label>
    <input type="text" id="name" name="name" required><br>
    <label for="first_name">Prénom:</label>
    <input type="text" id="first_name" name="first_name" required><br>
    <label for="class_name">Classe (ex: 6ème B):</label>
    <input type="text" id="class_name" name="class_name" required><br>
    <label for="password">Mot de passe:</label>
    <input type="password" id="password" name="password" required><br>
    <label for="confirm_password">Confirmer le mot de passe:</label>
    <input type="password" id="confirm_password" name="confirm_password" required><br>
    <button type="submit">S'inscrire</button>
</form>

<!-- message -->
<?php if (isset($_SESSION['success'])) : ?>
    <div class="success-message">
        <?= ($_SESSION['success']) ?>
        <?php unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])) : ?>
    <div class="error-message">
        <?= ($_SESSION['error']) ?>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>