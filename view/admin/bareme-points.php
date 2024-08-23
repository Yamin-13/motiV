<h1>Gestion des Paramètres de Points</h1>

<?php if (isset($_SESSION['success'])) : ?>
    <div class="success-message">
        <?= $_SESSION['success'] ?>
        <?php unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<form action="/ctrl/admin/bareme-points.php" method="post">
    <div>
        <label for="points_per_hour">Points par Heure :</label>
        <input type="number" id="points_per_hour" name="points_per_hour" value="<?= ($configurations['points_per_hour']) ?>" required>
    </div>
    <div>
        <label for="ine_validation_points">Points pour Validation INE :</label>
        <input type="number" id="ine_validation_points" name="ine_validation_points" value="<?= ($configurations['ine_validation_points']) ?>" required>
    </div>
    <button type="submit">Mettre à jour</button>
</form>