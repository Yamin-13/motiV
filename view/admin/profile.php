<h2 class="secret-message">Bonjour, Admininistrateur <?= ($_SESSION['user']['name']) ?>.</h2>
<ul class="admin-actions">
    <li><a class="header-link" href="">Option</a></li>

</ul>
<a href="/ctrl/login/logout.php">se deconnecter</a>

<h2>Associations en attente</h2>
<table>
    <tr>
        <th>Nom</th>
        <th>Description</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($pendingAssociations as $association) : ?>
        <tr>
            <td><?= ($association['name']) ?></td>
            <td><?= ($association['description']) ?></td>
            <td>
                <form action="/ctrl/admin/update-status.php" method="post" style="display:inline;">
                    <input type="hidden" name="type" value="association">
                    <input type="hidden" name="id" value="<?= $association['id'] ?>">
                    <button type="submit" name="action" value="approve">Accepter</button>
                    <a href="/view/admin/reject-reason.php?type=association&id=<?= $association['id'] ?>">Rejeter</a>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<h2>Entreprises en attente</h2>
<table>
    <tr>
        <th>Nom</th>
        <th>Adresse</th>
        <th>Numéro SIRET</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($pendingPartners as $partner) : ?>
        <tr>
            <td><?= ($partner['name']) ?></td>
            <td><?= ($partner['address']) ?></td>
            <td><?= ($partner['siret_number']) ?></td>
            <td>
                <form action="/ctrl/admin/update-status.php" method="post" style="display:inline;">
                    <input type="hidden" name="type" value="partner">
                    <input type="hidden" name="id" value="<?= $partner['id'] ?>">
                    <button type="submit" name="action" value="approve">Accepter</button>
                    <a href="/view/admin/reject-reason.php?type=partner&id=<?= $partner['id'] ?>">Rejeter</a>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>