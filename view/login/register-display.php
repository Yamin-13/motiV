<main class="login-register">
<div class="auth-container">
    <form action="/ctrl/login/register.php" method="post">
        <h2>Inscription</h2>

        <!-- E-mail -->
        <div class="input-box">
            <input type="text" name="email" placeholder="Email" value="<?= ($_SESSION['form_data']['email'] ?? '') ?>" required>
        </div>

        <!-- PASSWORD -->
        <div class="input-box">
            <input type="password" name="password" placeholder="Mot de Passe" required>
        </div>

        <!-- Confirm PASSWORD -->
        <div class="input-box">
            <input type="password" name="confirm_password" placeholder="Confirmer le Mot de Passe" required>
        </div>

        <button class="submit-form" type="submit">Inscription</button>

        <div class="sign-link">
            <p>Déjà Inscrits? <a href="/ctrl/login/login-display.php">S'Identifier</a></p>
        </div>

        <!-- Messages -->
        <div class="error-message">
            <?php
            if (isset($_SESSION['error'])) {
                echo '<p class="error-message">' . $_SESSION['error'] . '</p>';
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['success'])) {
                echo '<p class="messageInscription">' . $_SESSION['success'] . '</p>';
                unset($_SESSION['success']);
            } elseif (isset($_SESSION['error'])) {
                echo '<p class="error-message">' . $_SESSION['error'] . '</p>';
                unset($_SESSION['error']);
            }
            ?>
        </div>
    </form>
</div>
</main>