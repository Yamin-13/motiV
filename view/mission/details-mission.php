<h1 class="details-mission-title">Détails de la Mission</h1>

<!-- Message de succès ou d'erreur -->
<?php if (isset($_SESSION['success'])) : ?>
    <div class="details-mission-success-message">
        <?= $_SESSION['success'] ?>
        <?php unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])) : ?>
    <div class="details-mission-error-message">
        <?= $_SESSION['error'] ?>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<?php if ($mission): ?>
    <section class="details-mission-container">
        <div class="details-mission-info">
            <h2 class="details-mission-title-mission"><?= ($mission['title']) ?></h2>
            <p><span>Description:</span> <?= ($mission['description']) ?></p>
            <p><span>Points attribués :</span> <?= ($mission['point_award']) ?></p>
            <p><span>Durée de la mission:</span> <?= $durationInHours ?> heure(s)</p>
            <p><span>Date de Début:</span> <?= $startDateFormatted ?> à <?= $startTimeFormatted ?></p>
            <p><span>Date de Fin:</span> <?= $endDateFormatted ?> à <?= $endTimeFormatted ?></p>
            <p><span>Nombre de Places:</span> <?= ($mission['number_of_places']) ?></p>
            <p><span>Association :</span> <?= $mission['association_name'] ?></p>
        </div>

        <div class="details-mission-image">
            <?php if ($mission['image_filename']): ?>
                <img src="/upload/<?= ($mission['image_filename']) ?>" alt="Image de la mission">
            <?php endif; ?>
        </div>
    </div>

    <!-- Section pour les jeunes inscrits (admin association) -->
    <?php if (isset($_SESSION['user']) && in_array($_SESSION['user']['idRole'], [50, 55])) : ?>
        <h3 class="details-mission-subtitle">Jeunes Inscrits</h3>
        <?php if (!empty($registeredUsers)) : ?>
            <ul class="details-mission-list">
                <?php foreach ($registeredUsers as $user) : ?>
                    <li><?= $user['first_name'] . ' ' . $user['name'] . ' (' . $user['email'] . ')' ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>Aucun jeune inscrit pour cette mission.</p>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Affichage pour les jeunes (participant) -->
    <?php 
    $isPastMission = strtotime($mission['end_date_mission']) < time();
    $isNoMorePlaces = $mission['number_of_places'] <= 0;
    ?>

    <?php if (isset($_SESSION['user']) && $_SESSION['user']['idRole'] == 60) : ?>
        <?php if ($isPastMission) : ?>
            <p class="details-mission-status"><strong>Mission terminée</strong></p>
        <?php elseif ($mission['status'] == 'open') : ?>
            <?php if (isUserRegisteredForMission($_SESSION['user']['id'], $mission['id'], $dbConnection)) : ?>
                <p class="details-mission-status"><strong>Vous êtes inscrit à cette mission.</strong></p>
                <a href="/ctrl/mission/unregister-mission.php?id=<?= $mission['id'] ?>" class="details-mission-btn">Annuler la Mission</a>
            <?php elseif ($isNoMorePlaces): ?>
                <p class="details-mission-status"><strong>Plus de place disponible</strong></p>
            <?php else: ?>
                <form action="/ctrl/mission/register-mission.php" method="POST">
                    <input type="hidden" name="idMission" value="<?= $mission['id'] ?>">
                    <button type="submit" class="details-mission-btn">S'inscrire à la mission</button>
                </form>
            <?php endif; ?>
        <?php else: ?>
            <p class="details-mission-status"><strong>Mission terminée ou complète</strong></p>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Liens de retour -->
    <div class="details-mission-back">
        <?php if (isset($_SESSION['user'])): ?>
            <?php if (in_array($_SESSION['user']['idRole'], [50, 55])) : ?>
                <a href="/ctrl/mission/mission-list.php" class="details-mission-btn">Retour à la liste des missions</a>
            <?php elseif ($_SESSION['user']['idRole'] == 60) : ?>
                <a href="/ctrl/mission/mission-list-public.php" class="details-mission-btn">Retour à la liste des missions</a>
            <?php endif; ?>
        <?php else: ?>
            <a href="/ctrl/login/login-display.php" class="details-mission-btn">Connectez-vous</a>
            <a href="/ctrl/mission/mission-list-public.php" class="details-mission-btn">Retour à la liste des missions</a>
        <?php endif; ?>
    </div>

<?php else: ?>
    <p>La mission spécifiée n'existe pas.</p>
<?php endif; ?>