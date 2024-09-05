<h1>Historique des Achats</h1>

<a href="/ctrl/reward/my-unique-code.php">Mes codes et QR codes</a>

<?php if ($purchases && count($purchases) > 0) : ?>
    <table>
        <thead>
            <tr>
                <th>Récompense</th>
                <th>Date d'Achat</th>
                <th>Points Dépensés</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($purchases as $purchase) : ?>
                <tr>
                    <td><?= ($purchase['reward_title']) ?></td>
                    <td><?= ($purchase['transaction_date']) ?></td>
                    <td><?= ($purchase['number_of_points']) ?> points</td>
                    <td>
                        <!-- Bouton Détails -->
                        <a href="/ctrl/reward/reward-details.php?idReward=<?= $purchase['idReward'] ?>">Détails</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>Vous n'avez effectué aucun achat pour le moment.</p>
<?php endif; ?>

<a href="/ctrl/young/profile.php" class="back-button">Retour au profil</a>