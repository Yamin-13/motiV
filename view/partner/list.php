

<h1>Liste des Entreprises et leurs Partenaires</h1>
<table class="user-management-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom de l'Entreprise</th>
            <th>Nom du Partenaire</th>
            <th>Prénom du Partenaire</th>
            <th>Email du Partenaire</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($partners as $partner): ?>
            <tr>
                <td><?=($partner['id']) ?></td>
                <td><?=($partner['partner_name']) ?></td>
                <td><?=($partner['partner_full_name']) ?></td>
                <td><?=($partner['partner_first_name']) ?></td>
                <td><?=($partner['partner_email']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>