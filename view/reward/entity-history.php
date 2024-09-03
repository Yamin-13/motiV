<h1>Historique des échanges - <?= $entity['name'] ?></h1>

<?php if (!empty($rewardsHistory)) : ?>
    <table>
        <tr>
            <th>Titre</th>
            <th>Nombre d'échanges</th>
            <th>Disponibilité</th>
            <th>Prix</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($rewardsHistory as $reward) : ?>
            <tr>
                <td><?= $reward['title'] ?></td>
                <td><?= $reward['total_exchanges'] ?></td>
                <td><?= $reward['quantity_available'] ?></td>
                <td><?= $reward['reward_price'] ?> points</td>
                <td><a href="/ctrl/reward/entity-history-details.php?idReward=<?= $reward['id'] ?>">Détails</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else : ?>
    <p>Aucune récompense échangée.</p>
<?php endif; ?>