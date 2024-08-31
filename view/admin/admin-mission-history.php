<h1>Historique des Missions Accomplies</h1>

<?php if ($missions && count($missions) > 0): ?>
    <?php foreach ($missions as $association => $associationMissions): ?>
        <h2>Association : <?= ($association) ?></h2>
        <?php foreach ($associationMissions as $mission): ?>
            <h3><?= ($mission['title']) ?></h3>
            <p><strong>Date :</strong> <?= date('d/m/Y', strtotime($mission['start_date_mission'])) ?></p>
            <p><strong>Participants :</strong></p>
            <ul>
                <?php foreach ($mission['participants'] as $participant): ?>
                    <li>
                        <?= ($participant['first_name'] . ' ' . $participant['name']) ?> - <?= $participant['status'] === 'completed' ? 'Présent' : 'Absent' ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <a href="/ctrl/mission/details-mission.php?id=<?= $mission['id'] ?>">Détails</a>
        <?php endforeach; ?>
    <?php endforeach; ?>
<?php else: ?>
    <p>Aucune mission accomplie.</p>
<?php endif; ?>

<a href="/ctrl/admin/profile.php">Retour au profil</a>