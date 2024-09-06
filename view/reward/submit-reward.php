<h1>Soumettre une Récompense</h1>

<?php if (isset($_SESSION['error'])) : ?>
    <div class="error-message">
        <?= ($_SESSION['error']) ?>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['success'])) : ?>
    <div class="success-message">
        <?= ($_SESSION['success']) ?>
        <?php unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<form action="/ctrl/reward/submit-reward-process.php" method="POST" enctype="multipart/form-data">
    <label for="title">Titre de la Récompense :</label><br>
    <input type="text" id="title" name="title" required><br><br>

    <label for="description">Description :</label><br>
    <textarea id="description" name="description" rows="5" cols="50" required></textarea><br><br>

    <label for="reward_price">Prix (en points) :</label><br>
    <input type="number" id="reward_price" name="reward_price" min="0" required><br><br>

    <label for="quantity_available">Quantité Disponible :</label><br>
    <input type="number" id="quantity_available" name="quantity_available" min="1" required><br><br>

    <label for="category">Catégorie :</label><br>
    <select id="category" name="idCategory" required>
        <option value="">Sélectionner une catégorie</option>
        <option value="1">Événements et Activités</option>
        <option value="2">Bons d'Achat</option>
        <option value="3">Produits et Gadgets</option>
        <option value="4">Repas et Boissons</option>
        <option value="5">Sports et Loisirs</option>
        <option value="6">Voyages et Séjours</option>
        <option value="7">Éducation et Apprentissage</option>
        <option value="8">Bien-être et Santé</option>
        <option value="9">Culture et Divertissement</option>
    </select><br><br>

    <label for="image">Image de la Récompense :</label><br>
    <input type="file" id="image" name="image" accept="image/*"><br><br>

    <h3>Voulez vous définir une date de début et/ou d'utilisation de coupon ?</h3>
    <!-- Date de début d'utilisation de la récompense -->
    <label for="start_date_usage">Date de début d'utilisation :</label><br>
    <input type="date" id="start_date_usage" name="start_date_usage"><br><br>

    <!-- Date de fin d'utilisation de la récompense -->
    <label for="expiration_date">Date limite d'utilisation de la récompense :</label><br>
    <input type="date" id="expiration_date" name="expiration_date"><br><br>

    <!-- Id caché pour la mairie ou le partenaire -->
    <input type="hidden" name="idCityHall" value="<?= ($idCityHall) ?>">
    <input type="hidden" name="idPartner" value="<?= ($idPartner) ?>">

    <button type="submit">Soumettre la Récompense</button>
</form>

<a href="/ctrl/profile/display.php">Retour au profil</a>