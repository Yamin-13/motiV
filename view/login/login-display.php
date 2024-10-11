<main class="login-register">
    <div class="auth-container">
        <form action="/ctrl/login/login.php" method="post">
            <h2>S'Identifier</h2>

            <!-- E-mail -->
            <div class="input-box">
                <input type="text" name="email" id="code" placeholder="Email" required>
            </div>

            <!-- PASSWORD -->
            <div class="input-box">
                <input type="password" name="password" id="label" placeholder="Mot De Passe" required>
            </div>

            <div class="forgot-pass">
                <a href="/ctrl/password/display-forgot-password.php">Mot de passe oublié?</a>
            </div>

            <button class="submit-form" type="submit">S'Identifier</button>

            <div class="sign-link">
                <p>Pas encore inscrits? <a href="/ctrl/login/register-display.php">Inscription</a></p>
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