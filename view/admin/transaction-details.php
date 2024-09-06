<h1>Détails de la Récompense</h1>

<h2><?= ($reward['title']) ?></h2>
<p><strong>Description :</strong> <?= ($reward['description']) ?></p>
<p><strong>Prix :</strong> <?= ($reward['reward_price']) ?> points</p>
<p><strong>Quantité Disponible :</strong> <?= ($reward['quantity_available']) ?></p>

<h2>Acheteurs</h2>

<?php if ($purchasers && count($purchasers) > 0) : ?>
    <table>
        <thead>
            <tr>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Date de l'achat</th>
                <th>Code unique</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($purchasers as $purchaser) : ?>
                <tr>
                    <td><?= ($purchaser['first_name']) ?></td>
                    <td><?= ($purchaser['name']) ?></td>
                    <td><?= ($purchaser['transaction_date']) ?></td>
                    <td><?= ($purchaser['code']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>Aucun achat trouvé pour cette récompense.</p>
<?php endif; ?>

<a href="/ctrl/admin/transaction-list.php">Retour à la liste des transactions</a>