<h2>Inscription Association</h2>
<form action="/ctrl/register/register-association.php" method="POST">
    <input type="hidden" name="idUser" value="<?= ($_SESSION['user']['id']) ?>">
    <label for="name">Nom de l'association:</label>
    <input type="text" id="name" name="name" required><br>
    <label for="email">Email de l'association:</label>
    <input type="email" id="email" name="email" required><br>
    <label for="description">Description:</label>
    <textarea id="description" name="description" required></textarea><br>
    <label for="phone_number">Numéro de téléphone:</label>
    <input type="text" id="phone_number" name="phone_number" required><br>
    <label for="address">Adresse:</label>
    <input type="text" id="address" name="address" required><br>
    <button type="submit">Enregistrer l'association</button>
</form>