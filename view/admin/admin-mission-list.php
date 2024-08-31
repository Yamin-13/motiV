<h1>Missions en cours</h1>

<?php if ($missions && count($missions) > 0): ?>
    <?php foreach ($missions as $association => $associationMissions): ?>
        <h2>Association : <?= ($association) ?></h2>
        <table>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Date</th>
                    <th>Nombre de Jeunes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($associationMissions as $mission): ?>
                    <tr>
                        <td><?= ($mission['title']) ?></td>
                        <td><?= date('d/m/Y', strtotime($mission['start_date_mission'])) ?></td>
                        <td><?= ($mission['num_participants']) ?></td>
                        <td><a href="/ctrl/mission/details-mission.php?id=<?= $mission['id'] ?>">Détails</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endforeach; ?>
<?php else: ?>
    <p>Aucune mission en cours.</p>
<?php endif; ?>

<a href="/ctrl/admin/profile.php">Retour au profil</a>