<h1>Liste des Entreprises et leurs Partenaires</h1>
<table class="user-management-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom de l'Entreprise</th>
            <th>Nom du Partenaire</th>
            <th>Prénom du Partenaire</th>
            <th>Email du Partenaire</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($partners as $partner) : ?>
            <tr>
                <td><?= ($partner['id']) ?></td>
                <td><?= ($partner['partner_name']) ?></td>
                <td><?= ($partner['partner_full_name']) ?></td>
                <td><?= ($partner['partner_first_name']) ?></td>
                <td><?= ($partner['partner_email']) ?></td>
                <td><a href="/ctrl/partner/details.php?id=<?=($partner['id']) ?>">
                        <button>Détails</button>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>