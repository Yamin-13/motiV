<h1>Liste des Missions Disponibles</h1>

<!-- message -->
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
    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Description</th>
                <th>Date de Début</th>
                <th>Heure de Début</th>
                <th>Date de Fin</th>
                <th>Heure de Fin</th>
                <th>Durée</th>
                <th>Points par Heure</th>
                <th>Nombre de Places</th>
                <th>Association</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($missions as $mission) : ?>
                <tr>
                    <td><?= ($mission['title']) ?></td>
                    <td><?= ($mission['description']) ?></td>
                    <td><?= ($mission['start_date_formatted']) ?></td>
                    <td><?= ($mission['start_time_formatted']) ?></td>
                    <td><?= ($mission['end_date_formatted']) ?></td>
                    <td><?= ($mission['end_time_formatted']) ?></td>
                    <td><?= ($mission['duration_in_hours']) ?> heure(s)</td>
                    <td><?= ($mission['point_award']) ?></td>
                    <td><?= ($mission['number_of_places']) ?></td>
                    <td><?= ($mission['association_name']) ?></td>
                    <td>
                        <a href="/ctrl/mission/details-mission.php?id=<?= $mission['id'] ?>">Voir Détails</a>
                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['idRole'] == 60) : ?>
                            <?php if ($mission['status'] == 'open') : ?>
                                <?php if (isUserRegisteredForMission($_SESSION['user']['id'], $mission['id'], $dbConnection)) : ?>
                                    <a href="/ctrl/mission/unregister-mission.php?id=<?= $mission['id'] ?>">Annuler la Mission</a>
                                <?php elseif ($mission['number_of_places'] > 0): ?>
                                    <a href="/ctrl/mission/register-mission.php?id=<?= $mission['id'] ?>">Accepter la Mission</a>
                                <?php else: ?>
                                    <p>Plus de place disponible</p>
                                <?php endif; ?>
                            <?php else: ?>
                                <p>Mission complète</p>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>Aucune mission disponible pour le moment.</p>
<?php endif; ?>