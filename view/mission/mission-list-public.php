<h1>Missions Disponibles</h1>

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

<?php if ($missions && count($missions) > 0) : ?>
    <div class="missions-list">
        <?php foreach ($missions as $mission) : ?>
            <?php
            // Calcul si la mission est déjà passée ou si elle n'a plus de places
            $isPastMission = !empty($mission['end_date_mission']) && strtotime($mission['end_date_mission']) < time();
            $isNoMorePlaces = $mission['number_of_places'] <= 0;

            // Ajoute une classe 'grayscale' si la mission est passée ou n'a plus de places
            $grayscaleClass = ($isPastMission || $isNoMorePlaces) ? 'grayscale-mission-page' : '';
            ?>

            <div class="mission-item <?= $grayscaleClass ?>">
                <?php if (!empty($mission['image_filename'])) : ?>
                    <img src="/upload/<?= $mission['image_filename'] ?>" alt="<?= $mission['title'] ?>" width="200">
                <?php endif; ?>

                <h2><?= $mission['title'] ?></h2>
                <p><strong>Points :</strong> <?= $mission['point_award'] ?></p>
                <p><strong>Description :</strong> <?= $mission['description'] ?></p>
                <p><strong>Date de début :</strong> <?= $mission['start_date_formatted'] ?> à <?= $mission['start_time_formatted'] ?></p>
                <p><strong>Date de fin :</strong> <?= $mission['end_date_formatted'] ?> à <?= $mission['end_time_formatted'] ?></p>
                <p><strong>Nombre de places :</strong> <?= $mission['number_of_places'] ?></p>
                <p><strong>Association :</strong> <?= $mission['association_name'] ?></p>

                <a href="/ctrl/mission/details-mission.php?id=<?= $mission['id'] ?>" class="details-button">Voir Détails</a>

                <?php if ($isPastMission) : ?>
                    <p class="past-mission-text"><strong>Mission terminée</strong></p>
                <?php elseif ($isNoMorePlaces) : ?>
                    <p class="unavailable-text"><strong>Aucune place disponible.</strong></p>
                <?php else : ?>
                    <?php if (isset($_SESSION['user']) && isUserRegisteredForMission($_SESSION['user']['id'], $mission['id'], $dbConnection)) : ?>
                        <p class="registered-text"><strong>Vous êtes inscrit à cette mission.</strong></p>
                    <?php else : ?>
                        <form action="/ctrl/mission/register-mission.php" method="POST">
                            <input type="hidden" name="idMission" value="<?= $mission['id'] ?>">
                            <button type="submit">S'inscrire à la mission</button>
                        </form>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php else : ?>
    <p>Aucune mission disponible pour le moment.</p>
<?php endif; ?>