  <main>
      <h2 class="text-right">Bienvenue</h2>
      <div>
          <form action="/ctrl/login/register.php" method="post" enctype="multipart/form-data">
              <h2>Inscription</h2>
              <div class="input-box">
                  <input type="text" name="email" placeholder="Email">
              </div>
              <div class="input-box">
                  <input type="password" name="password" placeholder="Mot de Passe">
              </div>
              <button class="submit-form" type="submit">Inscription</button>
              <div class="sign-link">
                  <p>Déjà Inscrits? <a href="/ctrl/login/login-display.php">S'Identifier</a></p>
              </div>
          </form>
      </div>
  </main>