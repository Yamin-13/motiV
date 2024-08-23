<form action="/ctrl/mission/add-mission.php" method="post" enctype="multipart/form-data">
    <div>
        <label for="title">Titre de la Mission :</label>
        <input type="text" id="title" name="title" required>
    </div>
    <div>
        <label for="description">Description :</label>
        <textarea id="description" name="description" required></textarea>
    </div>
    <div>
        <label for="start_date">Date de Début :</label>
        <input type="date" id="start_date" name="start_date" placeholder="jj/mm/aa" required>
    </div>
    <div>
        <label for="start_time">Heure de Début :</label>
        <input type="time" id="start_time" name="start_time" required>
    </div>

    <div>
        <label for="end_date">Date de Fin :</label>
        <input type="date" id="end_date" name="end_date" placeholder="jj/mm/aa" required>
    </div>
    <div>
        <label for="end_time">Heure de Fin :</label>
        <input type="time" id="end_time" name="end_time" required>
    </div>

    <div>
        <label for="number_of_places">Nombre de Places :</label>
        <input type="number" id="number_of_places" name="number_of_places" required>
    </div>
    <div>
        <label for="image">Image Représentatrice :</label>
        <input type="file" id="image" name="image">
    </div>
    <button type="submit">Soumettre la Mission</button>
</form>

<?php if (isset($_SESSION['success'])) : ?>
    <div class="success-message">
        <?= ($_SESSION['success']) ?>
        <?php unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])) : ?>
    <div class="error-message">
        <?= ($_SESSION['error']) ?>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>
<script src="/asset/js/calculate.js"></script>