<h1>Historique des Missions Accomplies</h1>

<?php if (isset($_SESSION['success'])) : ?>
    <div class="success-message">
        <?= $_SESSION['success'] ?>
        <?php unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<?php if ($missions && count($missions) > 0) : ?>
    <?php foreach ($missions as $mission) : ?>
        <h2><?= ($mission['title']) ?></h2>
        <p><strong>Description :</strong> <?= ($mission['description']) ?></p>
        <p><strong>Points attribués :</strong> <?= ($mission['point_award']) ?></p>
        <p><strong>Date de début :</strong> <?= date('d/m/Y H:i', strtotime($mission['start_date_mission'])) ?></p>
        <p><strong>Date de fin :</strong> <?= date('d/m/Y H:i', strtotime($mission['end_date_mission'])) ?></p>

        <h3>Participants</h3>
        <?php
        $participants = getMissionParticipants($mission['id'], $dbConnection);
        if ($participants) :
        ?>
            <ul>
                <?php foreach ($participants as $participant) : ?>
                    <li>
                        <?= ($participant['first_name'] . ' ' . $participant['name']) ?> - <?= $participant['status'] === 'completed' ? 'Présent' : 'Absent' ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>Aucun participant pour cette mission.</p>
        <?php endif; ?>
    <?php endforeach; ?>
<?php else : ?>
    <p>Aucune mission accomplie pour le moment.</p>
<?php endif; ?>

<a href="/ctrl/mission/mission-list.php">Retour à la liste des missions</a>