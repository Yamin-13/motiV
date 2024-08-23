<h1>Liste des Missions Disponibles</h1>

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
                            <a href="/ctrl/mission/register-mission.php?id=<?= $mission['id'] ?>">Accepter la Mission</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>Aucune mission disponible pour le moment.</p>
<?php endif; ?>