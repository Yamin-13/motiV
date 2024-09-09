<div class="contact-form">
    <h1>Contactez l'Administrateur</h1>

    <!-- Affichage des messages d'erreur ou de succès -->
    <?php if (isset($_SESSION['success'])) : ?>
        <div class="success-message"><?= $_SESSION['success'] ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])) : ?>
        <div class="error-message"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Formulaire de contact -->
    <form action="/ctrl/contact/contact-display.php" method="POST">
        <label for="subject">Sujet :</label>
        <input type="text" id="subject" name="subject" required><br>

        <label for="body">Message :</label>
        <textarea id="body" name="body" rows="5" required></textarea><br>

        <button type="submit">Envoyer</button>
    </form>
</div>