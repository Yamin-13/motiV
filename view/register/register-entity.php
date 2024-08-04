<h2>Inscription de l'utilisateur</h2>
<form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="role" value="<?=($_GET['role']) ?>">
    <label for="email">Email:</label>
    <input type="text" id="email" name="email"><br>
    <label for="name">Nom:</label>
    <input type="text" name="name" id="name"><br>
    <label for="first_name">Prénom:</label>
    <input type="text" name="first_name" id="first_name"><br>
    <label for="password">Mot de passe:</label>
    <input type="password" id="password" name="password"><br>
    <div>
        <input type="file" id="file" name="file" onchange="updateFileName()">
        <label for="file" class="inputfile-label-register">Votre avatar</label>
        <span id="file-name">Aucun fichier sélectionné</span>
    </div>
    <input type="submit" value="S'inscrire">
</form>

<script>
function updateFileName() {
    const input = document.getElementById('file');
    const fileNameSpan = document.getElementById('file-name');
    fileNameSpan.textContent = input.files[0] ? input.files[0].name : 'Aucun fichier sélectionné';
}
</script>

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
