<h1>Historique des Missions Accomplies</h1>

<?php if ($missions && count($missions) > 0) : ?>
    <?php foreach ($missions as $mission) : ?>
        <h2><?= ($mission['title']) ?></h2>
        <p><strong>Description :</strong> <?= ($mission['description']) ?></p>
        <p><strong>Points attribués :</strong> <?= ($mission['point_award']) ?></p>
        <p><strong>Date de début :</strong> <?= date('d/m/Y H:i', strtotime($mission['start_date_mission'])) ?></p>
        <p><strong>Date de fin :</strong> <?= date('d/m/Y H:i', strtotime($mission['end_date_mission'])) ?></p>
        <a href="/ctrl/mission/details-mission.php?id=<?= $mission['id'] ?>">Voir Détails</a>
        <hr>
    <?php endforeach; ?>
<?php else : ?>
    <p>Aucune mission accomplie pour le moment.</p>
<?php endif; ?>

<a href="/ctrl/young//profile.php">Retour au profil</a>