<h2>Inscription de l'utilisateur</h2>
<form action="" method="post">
    <input type="hidden" name="role" value="<?= ($_GET['role']) ?>">
    <label for="email">Email:</label>
    <input type="text" id="email" name="email"><br>
    <label for="name">Nom:</label>
    <input type="text" name="name" id="name"><br>
    <label for="first_name">Prénom:</label>
    <input type="text" name="first_name" id="first_name"><br>
    <label for="password">Mot de passe:</label>
    <input type="password" id="password" name="password"><br>
    <input type="submit" value="S'inscrire">
</form>