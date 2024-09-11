<h2>Inscription de l'utilisateur</h2>
<form action="" method="post">
    <input type="hidden" name="role" value="<?=($_GET['role']) ?>">
    <label for="email">Email:</label>
    <input type="text" id="email" name="email" required><br>
    
    <label for="name">Nom:</label>
    <input type="text" name="name" id="name"><br>
    
    <label for="first_name">Prénom:</label>
    <input type="text" name="first_name" id="first_name"><br>
    
    <label for="password">Mot de passe:</label>
    <input type="password" id="password" name="password" required><br>
    
    <label for="confirm_password">Confirmer le mot de passe:</label>
    <input type="password" id="confirm_password" name="confirm_password" required><br>
    
    <input type="submit" value="S'inscrire">
</form>

<!-- Messages -->
<div class="error-message">
    <?php
    // message du formulaire de login ca affiche le contenu de "error"
    if (isset($_SESSION['error'])) { // isset vérifie si ($_SESSION['error']) n'est pas null
        echo '<p class= "error-message">' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']); // unset retire ($_SESSION['error']) de la session pour supprimer le message d'erreur de la session
    }

    // message du formulaire d'inscription ca affiche le contenu de "success" ou "error"
    if (isset($_SESSION['success'])) { // ca vérifie s'il y a le message de succès dans la session
        echo '<p class="messageInscription">' . $_SESSION['success'] . '</p>'; // affiche
        unset($_SESSION['success']); // supprime le message de succès de la session
    } elseif (isset($_SESSION['error'])) { // ca vérifie s'il y a un message d'erreur dans la session
        echo '<p class="error-message">' . $_SESSION['error'] . '</p>'; // affiche
        unset($_SESSION['error']); // supprime le message d'erreur de la session
    }
    ?>
</div>