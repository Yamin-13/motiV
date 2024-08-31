<h1>Liste des Missions de l'Association</h1>

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
                <th>Points attribués</th>
                <th>Nombre de Places</th>
                <th>Status</th>
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
                    <td><?= ($mission['status']) ?></td>
                    <td>
                        <a href="/ctrl/mission/details-mission.php?id=<?= $mission['id'] ?>">Voir</a>
                        <?php if ($mission['status'] == 'complete') : ?>
                            <a href="/ctrl/mission/validate-mission.php?id=<?= $mission['id'] ?>">Valider la mission</a>
                        <?php endif; ?>
                        <a href="/ctrl/mission/delete-mission.php?id=<?= $mission['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette mission ?');">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>Aucune mission trouvée pour cette association.</p>
<?php endif; ?>

<a href="/ctrl/mission/add-mission-display.php">Ajouter une Nouvelle Mission</a>