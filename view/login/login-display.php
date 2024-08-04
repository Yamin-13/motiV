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
        <a href="/ctrl/password/display-forgot-password.php">Mot de passe oublié?</a>
    </div>
    <button class="submit-form" type="submit">S'Identifier</button>
    <div class="sign-link">
        <p>Pas encore inscrits? <a href="/ctrl/login/register-display.php">Inscription</a></p>
    </div>

    <!-- Messages -->
    <div class="error-message">
        <?php
        // message du formulaire de login ca affiche le contenue de "error"  
        if (isset($_SESSION['error'])) { // isset verifie si ($_SESSION['error']) est pas null
            echo '<p class= "error-message">' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']); // unset ca retire ($_SESSION['error']) de la session pour supprimer le message d'érreur de la session
        }

        // message du formulaire d'inscription ca affiche le contenu de "sucess" ou "error"
        if (isset($_SESSION['success'])) { // ca verifie s'il y a le message de succès dans la session
            echo '<p class="messageInscription">' . $_SESSION['success'] . '</p>'; // afiche
            unset($_SESSION['success']); // supprime le message de succès de la session
        } elseif (isset($_SESSION['error'])) { // ca vérifie s'il y a un message d'erreur dans la session
            echo '<p class="error-message">' . $_SESSION['error'] . '</p>'; // affiche
            unset($_SESSION['error']); // supprime le message d'erreur de la session
        }
        ?>
    </div>