<h1>Liste des Transactions</h1>

<?php if ($transactions && count($transactions) > 0) : ?>
    <table>
        <thead>
            <tr>
                <th>Titre de la Récompense</th>
                <th>Submitter</th>
                <th>Nombre d'Achats</th>
                <th>Quantité Restante</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $transaction) : ?>
                <tr>
                    <td><?= ($transaction['title']) ?></td>
                    <td><?= ($transaction['submitter_name']) ?></td>
                    <td><?= ($transaction['total_purchases']) ?></td>
                    <td><?= ($transaction['quantity_available']) ?></td>
                    <td>
                        <a href="/ctrl/admin/transaction-details.php?idReward=<?= urlencode($transaction['id']) ?>">Détails</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>Aucune transaction trouvée.</p>
<?php endif; ?>