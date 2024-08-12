<h2>Mettre à jour l'Établissement Scolaire</h2>
<form action="/ctrl/educational-establishment/update.php" method="POST">
    <input type="hidden" name="id" value="<?= $educationalEstablishment['id'] ?>">
    <label for="name">Nom de l'Établissement:</label>
    <input type="text" id="name" name="name" value="<?= $educationalEstablishment['name'] ?>" required><br>
    <label for="phone_number">Numéro de téléphone:</label>
    <input type="text" id="phone_number" name="phone_number" value="<?= $educationalEstablishment['phone_number'] ?>" required><br>
    <label for="address">Adresse:</label>
    <input type="text" id="address" name="address" value="<?= $educationalEstablishment['address'] ?>" required><br>
    <label for="email">Email de l'Établissement:</label>
    <input type="email" id="email" name="email" value="<?= $educationalEstablishment['email'] ?>" required><br>
    <label for="NIE_number">Numéro NIE:</label>
    <input type="text" id="NIE_number" name="NIE_number" value="<?= $educationalEstablishment['NIE_number'] ?>" required><br>
    <button type="submit">Mettre à jour l'Établissement</button>
</form>