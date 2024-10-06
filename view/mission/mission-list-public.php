<!-- Hero Section -->
<div class="mission-hero">
    <h2 class="page-title">Missions Disponibles</h2>
    <p>Rejoins les MotiV et Active le Changement</p>
</div>

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

<!-- Liste des Missions -->
<?php if ($missions && count($missions) > 0) : ?>
    <div class="missions-container">
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
                    <img src="/upload/<?= $mission['image_filename'] ?>" alt="<?= ($mission['title']) ?>">
                <?php endif; ?>

                <div class="mission-content">
                    <h2 class="mission-title"> <?= ($mission['title']) ?> </h2>
                    <p><strong>Le :</strong> <?= $mission['start_date_formatted'] ?> de <?= $mission['start_time_formatted'] ?> à <?= $mission['end_time_formatted'] ?></p>
                    <p><strong>Remporte :</strong> <?= ($mission['point_award']) ?> Vpoints</p>
                    <p><strong>Nombre de places :</strong> <?= ($mission['number_of_places']) ?></p>
                    <p><strong>Association :</strong> <?= ($mission['association_name']) ?></p>
                </div>

                <div class="mission-actions">
                    <a href="/ctrl/mission/details-mission.php?id=<?= $mission['id'] ?>" class="details-button">Voir Détails</a>

                    <?php if ($isPastMission) : ?>
                        <p class="status-text"><strong>Mission terminée</strong></p>
                    <?php elseif ($isNoMorePlaces) : ?>
                        <p class="status-text"><strong>Aucune place disponible.</strong></p>
                    <?php else : ?>
                        <?php if (isset($_SESSION['user']) && isUserRegisteredForMission($_SESSION['user']['id'], $mission['id'], $dbConnection)) : ?>
                            <p class="status-text"><strong>Vous êtes inscrit à cette mission.</strong></p>
                        <?php else : ?>
                            <form action="/ctrl/mission/register-mission.php" method="POST">
                                <input type="hidden" name="idMission" value="<?= $mission['id'] ?>">
                                <button type="submit" class="action-button">S'inscrire à la mission</button>
                            </form>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else : ?>
    <p>Aucune mission disponible pour le moment.</p>
<?php endif; ?>