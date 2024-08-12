<h2>Inscription via Invitation</h2>
<form action="/ctrl/register/register-via-invitation-handler.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="token" value="<?= $_SESSION['invitation']['token'] ?>">
    
    <label for="email">Email :</label>
    <input type="email" id="email" name="email" value="<?= $_SESSION['invitation']['email'] ?>" readonly><br>
    
    <label for="name">Nom :</label>
    <input type="text" id="name" name="name" required><br>
    
    <label for="first_name">Prénom :</label>
    <input type="text" id="first_name" name="first_name" required><br>
    
    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" required><br>
    
    <label for="confirm_password">Confirmer le mot de passe :</label>
    <input type="password" id="confirm_password" name="confirm_password" required><br>
    
    <label for="avatar">Avatar :</label>
    <input type="file" id="avatar" name="avatar"><br>
    
    <button type="submit">S'inscrire</button>
</form>
