  <h2>Mot de passe oublié</h2>
  <form action="/ctrl/password/forgot-password.php" method="post">
      <div>
          <label for="email">Email :</label>
          <input type="email" id="email" name="email" required>
      </div>
      <button type="submit">Envoyer</button>
  </form>