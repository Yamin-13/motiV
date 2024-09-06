<h1>Modifier la Mission</h1>

<?php if (isset($_SESSION['error'])) : ?>
    <div class="error-message">
        <?= $_SESSION['error'] ?>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<form action="/ctrl/mission/update-mission.php?id=<?= $idMission ?>" method="POST" enctype="multipart/form-data">
    <div>
        <label for="title">Titre de la Mission :</label>
        <input type="text" id="title" name="title" value="<?= ($mission['title']) ?>" required>
    </div>
    <div>
        <label for="description">Description :</label>
        <textarea id="description" name="description" required><?= ($mission['description']) ?></textarea>
    </div>
    <div>
        <label for="start_date">Date de Début :</label>
        <input type="date" id="start_date" name="start_date" value="<?= date('Y-m-d', strtotime($mission['start_date_mission'])) ?>" required>
    </div>
    <div>
        <label for="start_time">Heure de Début :</label>
        <input type="time" id="start_time" name="start_time" value="<?= date('H:i', strtotime($mission['start_date_mission'])) ?>" required>
    </div>
    <div>
        <label for="end_date">Date de Fin :</label>
        <input type="date" id="end_date" name="end_date" value="<?= date('Y-m-d', strtotime($mission['end_date_mission'])) ?>" required>
    </div>
    <div>
        <label for="end_time">Heure de Fin :</label>
        <input type="time" id="end_time" name="end_time" value="<?= date('H:i', strtotime($mission['end_date_mission'])) ?>" required>
    </div>
    <div>
        <label for="number_of_places">Nombre de Places :</label>
        <input type="number" id="number_of_places" name="number_of_places" value="<?= ($mission['number_of_places']) ?>" required>
    </div>
    <div>
        <label for="image">Image Représentatrice (Laissez vide pour ne pas changer) :</label>
        <input type="file" id="image" name="image">
    </div>
    <button type="submit">Mettre à jour la Mission</button>
</form>

<a href="/ctrl/mission/mission-list.php">Retour à la liste des missions</a>