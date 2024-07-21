<form action="/ctrl/login/login.php" method="post">
    <h2>S'Identifier</h2>
    <!-- E-mail -->
    <div class="input-box">
        <label for="code"></label>
        <input type="text" name="email" id="code" placeholder="Email" required>
    </div>
    <!-- PASSWORD -->
    <div class="input-box">
        <label for="label"></label>
        <input type="password" name="password" id="label" placeholder="Mot De Passe" required>
    </div>
    <div class="forgot-pass">
        <a href="#">Mot de passe oublié?</a>
    </div>
    <button class="submit-form" type="submit">S'Identifier</button>
    <div class="sign-link">
        <p>Pas encore inscrits? <a href="/ctrl/login/register-display.php">Inscription</a></p>
    </div>