<h1>Détails de l'étudiant</h1>
<p>Nom: <?= ($user['name']) ?></p>
<p>Prénom: <?= ($user['first_name']) ?></p>
<p>Email: <?= ($user['email']) ?></p>
<p>Numéro INE: <?= ($user['ine_number']) ?></p>
<p>Date de naissance: <?= ($user['date_of_birth']) ?></p>
<p>Adresse: <?= ($user['address']) ?></p>
<p>Nombre de points: <?= ($user['points']) ?></p>
<p>Date d'inscription: <?= ($user['registration_date']) ?></p>

<?php if (isset($_SESSION['success'])) : ?>
    <div class="success-message">
        <?=($_SESSION['success']) ?>
        <?php unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])) : ?>
    <div class="error-message">
        <?=($_SESSION['error']) ?>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>