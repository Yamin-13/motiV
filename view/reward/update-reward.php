<h1>Modifier la Récompense</h1>

<?php if (isset($_SESSION['error'])) : ?>
    <div class="error-message">
        <?= $_SESSION['error'] ?>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<form action="/ctrl/reward/update-reward.php?id=<?= $idReward ?>" method="POST" enctype="multipart/form-data">
    <label for="title">Titre de la Récompense :</label><br>
    <input type="text" id="title" name="title" value="<?= $reward['title'] ?>" required><br><br>

    <label for="description">Description :</label><br>
    <textarea id="description" name="description" rows="5" cols="50" required><?= $reward['description'] ?></textarea><br><br>

    <label for="reward_price">Prix (en points) :</label><br>
    <input type="number" id="reward_price" name="reward_price" min="0" value="<?= $reward['reward_price'] ?>" required><br><br>

    <label for="quantity_available">Quantité Disponible :</label><br>
    <input type="number" id="quantity_available" name="quantity_available" min="1" value="<?= $reward['quantity_available'] ?>" required><br><br>

    <label for="category">Catégorie :</label><br>
    <select id="category" name="idCategory" required>
        <option value="">Sélectionner une catégorie</option>
        <option value="1" <?= $reward['idCategory'] == 1 ? 'selected' : '' ?>>Événements et Activités</option>
        <option value="2" <?= $reward['idCategory'] == 2 ? 'selected' : '' ?>>Bons d'Achat</option>
        <option value="3" <?= $reward['idCategory'] == 3 ? 'selected' : '' ?>>Produits et Gadgets</option>
        <option value="4" <?= $reward['idCategory'] == 4 ? 'selected' : '' ?>>Repas et Boissons</option>
        <option value="5" <?= $reward['idCategory'] == 5 ? 'selected' : '' ?>>Sports et Loisirs</option>
        <option value="6" <?= $reward['idCategory'] == 6 ? 'selected' : '' ?>>Voyages et Séjours</option>
        <option value="7" <?= $reward['idCategory'] == 7 ? 'selected' : '' ?>>Éducation et Apprentissage</option>
        <option value="8" <?= $reward['idCategory'] == 8 ? 'selected' : '' ?>>Bien-être et Santé</option>
        <option value="9" <?= $reward['idCategory'] == 9 ? 'selected' : '' ?>>Culture et Divertissement</option>
        <!-- Ajoute d'autres catégories ici -->
    </select><br><br>

    <button type="submit">Mettre à jour</button>
</form>

<a href="/ctrl/profile/display.php">Retour au profil</a>