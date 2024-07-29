<?php if (isset($partner)): ?>
    <h2>Mettre à jour l'Entreprise</h2>
    <form action="/ctrl/partner/update.php" method="POST">
        <input type="hidden" name="id" value="<?=($partner['id']) ?>">
        <label for="name">Nom de l'Entreprise:</label>
        <input type="text" id="name" name="name" value="<?=($partner['name']) ?>" required><br>
        <label for="siret_number">Numéro SIRET:</label>
        <input type="text" id="siret_number" name="siret_number" value="<?=($partner['siret_number']) ?>" required><br>
        <label for="address">Adresse:</label>
        <input type="text" id="address" name="address" value="<?=($partner['address']) ?>" required><br>
        <label for="email">Email de l'Entreprise:</label>
        <input type="email" id="email" name="email" value="<?=($partner['email']) ?>" required><br>
        <button type="submit">Mettre à jour l'Entreprise</button>
    </form>
<?php else: ?>
    <p>Informations de l'entreprise non disponibles.</p>
<?php endif; ?>
