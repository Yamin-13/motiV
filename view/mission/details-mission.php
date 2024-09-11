<h1>Détails de la Mission</h1>

<!-- Message de succès ou d'erreur -->
<?php if (isset($_SESSION['success'])) : ?>
    <div class="success-message">
        <?= $_SESSION['success'] ?>
        <?php unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])) : ?>
    <div class="error-message">
        <?= $_SESSION['error'] ?>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<?php if ($mission): ?>
    <h2><?= ($mission['title']) ?></h2>
    <p><strong>Description:</strong> <?= ($mission['description']) ?></p>
    <p><strong>Points attribués :</strong> <?= ($mission['point_award']) ?></p>
    <p><strong>Durée de la mission:</strong> <?= $durationInHours ?> heure(s)</p>
    <p><strong>Date de Début:</strong> <?= $startDateFormatted ?> à <?= $startTimeFormatted ?></p>
    <p><strong>Date de Fin:</strong> <?= $endDateFormatted ?> à <?= $endTimeFormatted ?></p>
    <p><strong>Nombre de Places:</strong> <?= ($mission['number_of_places']) ?></p>

    <?php if ($mission['image_filename']): ?>
        <p><img src="/upload/<?= ($mission['image_filename']) ?>" alt="Image de la mission" width="200"></p>
    <?php endif; ?>

    <p><strong>Association :</strong> <?= $mission['association_name'] ?></p>

    <!-- Affichage des jeune inscrits pour les roles administrateur d'asso -->
    <?php if (isset($_SESSION['user']) && in_array($_SESSION['user']['idRole'], [50, 55])) : ?>
        <h3>Jeunes Inscrits</h3>
        <?php if (!empty($registeredUsers)) : ?>
            <ul>
                <?php foreach ($registeredUsers as $user) : ?>
                    <li><?= $user['first_name'] . ' ' . $user['name'] . ' (' . $user['email'] . ')' ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>Aucun jeune inscrit pour cette mission.</p>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Affichage pour les jeunes -->
    <?php 
    // calcul pour savoir si la mission est passé
    $isPastMission = strtotime($mission['end_date_mission']) < time();
    $isNoMorePlaces = $mission['number_of_places'] <= 0;
    ?>
    
    <?php if (isset($_SESSION['user']) && $_SESSION['user']['idRole'] == 60) : ?>
        <?php if ($isPastMission) : ?>
            <p class="past-mission-text"><strong>Mission terminée</strong></p>
        <?php elseif ($mission['status'] == 'open') : ?>
            <?php if (isUserRegisteredForMission($_SESSION['user']['id'], $mission['id'], $dbConnection)) : ?>
                <p class="registered-text"><strong>Vous êtes inscrit à cette mission.</strong></p>
                <a href="/ctrl/mission/unregister-mission.php?id=<?= $mission['id'] ?>">Annuler la Mission</a>
            <?php elseif ($isNoMorePlaces): ?>
                <p class="unavailable-text"><strong>Plus de place disponible</strong></p>
            <?php else: ?>
                <form action="/ctrl/mission/register-mission.php" method="POST">
                    <input type="hidden" name="idMission" value="<?= $mission['id'] ?>">
                    <button type="submit">S'inscrire à la mission</button>
                </form>
            <?php endif; ?>
        <?php else: ?>
            <p class="past-mission-text"><strong>Mission terminée ou complète</strong></p>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Liens de retour -->
    <?php if (isset($_SESSION['user'])): ?>
        <?php if (in_array($_SESSION['user']['idRole'], [50, 55])) : ?>
            <a href="/ctrl/mission/mission-list.php">Retour à la liste des missions</a>
        <?php elseif ($_SESSION['user']['idRole'] == 60) : ?>
            <a href="/ctrl/mission/mission-list-public.php">Retour à la liste des missions</a>
        <?php endif; ?>
    <?php else: ?>
        <a href="/ctrl/login/login-display.php">Connectez-vous</a>
        <a href="/ctrl/mission/mission-list-public.php">Retour à la liste des missions</a>
    <?php endif; ?>
<?php else: ?>
    <p>La mission spécifiée n'existe pas.</p>
<?php endif; ?>