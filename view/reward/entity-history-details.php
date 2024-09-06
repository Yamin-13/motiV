<h1>Détails de la récompense - <?= $reward['title'] ?></h1>

<p><strong>Description:</strong> <?= $reward['description'] ?></p>
<p><strong>Prix:</strong> <?= $reward['reward_price'] ?> points</p>
<p><strong>Disponibilité:</strong> <?= $reward['quantity_available'] ?></p>

<h2>Jeunes ayant échangé cette récompense</h2>

<?php if (!empty($purchasers)) : ?>
    <table>
        <tr>
            <th>Nom</th>
            <th>Date d'échange</th>
            <th>Code unique</th>
            <th>Date d'utilisation du code unique</th>
        </tr>
        <?php foreach ($purchasers as $purchaser) : ?>
            <tr>
                <td><?= $purchaser['first_name'] ?> <?= $purchaser['name'] ?></td>
                <td><?= $purchaser['transaction_date'] ?></td>
                <td><?= $purchaser['code'] ?></td>
                <td>
                    <?php if ($purchaser['used_at']) : ?>
                        <?= $purchaser['used_at'] ?>
                    <?php else : ?>
                        <em>Code unique non utilisé</em>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else : ?>
    <p>Aucun échange effectué pour cette récompense.</p>
<?php endif; ?>