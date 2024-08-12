<h2>Mettre à jour la Mairie</h2>
<form action="/ctrl/city-hall/update.php" method="POST">
    <input type="hidden" name="id" value="<?= $cityHall['id'] ?>">
    <label for="name">Nom de la Mairie:</label>
    <input type="text" id="name" name="name" value="<?= $cityHall['name'] ?>" required><br>
    <label for="phone_number">Numéro de téléphone:</label>
    <input type="text" id="phone_number" name="phone_number" value="<?= $cityHall['phone_number'] ?>" required><br>
    <label for="address">Adresse:</label>
    <input type="text" id="address" name="address" value="<?= $cityHall['address'] ?>" required><br>
    <label for="email">Email de la Mairie:</label>
    <input type="email" id="email" name="email" value="<?= $cityHall['email'] ?>" required><br>
    <label for="image_filename">Image:</label>
    <input type="file" id="image_filename" name="image_filename" value="<?= $cityHall['image_filename'] ?>"><br>
    <button type="submit">Mettre à jour la Mairie</button>
</form>