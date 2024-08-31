
<h1>Liste des Jeunes ayant Participé aux Missions</h1>

<?php if ($participants && count($participants) > 0) : ?>
    <table>
        <thead>
            <tr>
                <th>Nom du Jeune</th>
                <th>Email</th>
                <th>Nom de la Mission</th>
                <th>Date de la Mission</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($participants as $participant) : ?>
                <tr>
                    <td><?= ($participant['first_name'] . ' ' . $participant['name']) ?></td>
                    <td><?= ($participant['email']) ?></td>
                    <td><?= ($participant['mission_title']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($participant['start_date_mission'])) ?></td>
                    <td><?= ($participant['status'] === 'completed' ? 'Présent' : 'Absent') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>Aucun jeune n'a participé à des missions pour cette association.</p>
<?php endif; ?>

<a href="/ctrl/profile/display.php">Retour au Profil</a>