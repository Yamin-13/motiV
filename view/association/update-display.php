<h2>Mettre à jour l'Association</h2>
<form action="/ctrl/association/update.php" method="POST">
    <input type="hidden" name="id" value="<?= $association['id'] ?>">
    <label for="name">Nom de l'Association:</label>
    <input type="text" id="name" name="name" value="<?= $association['name'] ?>" required><br>
    <label for="description">Description:</label>
    <textarea id="description" name="description" required><?= $association['description'] ?></textarea><br>
    <label for="phone_number">Numéro de téléphone:</label>
    <input type="text" id="phone_number" name="phone_number" value="<?= $association['phone_number'] ?>" required><br>
    <label for="address">Adresse:</label>
    <input type="text" id="address" name="address" value="<?= $association['address'] ?>" required><br>
    <label for="email">Email de l'Association:</label>
    <input type="email" id="email" name="email" value="<?= $association['email'] ?>" required><br>
    <button type="submit">Mettre à jour l'Association</button>
</form>

