<h2>Réinitialiser le mot de passe</h2>
    <form action="/ctrl/password/reset-password.php" method="post">
        <input type="hidden" name="token" value="<?= $_GET['token'] ?>">
        <div>
            <label for="password">Nouveau mot de passe :</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Réinitialiser</button>
    </form>