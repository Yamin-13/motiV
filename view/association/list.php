

<h1>Liste des Associations et leurs Présidents</h1>
<table class="user-management-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom de l'Association</th>
            <th>Nom du Président</th>
            <th>Prénom du Président</th>
            <th>Email du Président</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($associations as $association): ?>
            <tr>
                <td><?=($association['id']) ?></td>
                <td><?=($association['association_name']) ?></td>
                <td><?=($association['president_name']) ?></td>
                <td><?=($association['president_first_name']) ?></td>
                <td><?=($association['president_email']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
