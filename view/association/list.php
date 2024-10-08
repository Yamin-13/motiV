<h1>Liste des Associations</h1>
<table class="user-management-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom de l'Association</th>
            <th>Nom du Président</th>
            <th>Prénom du Président</th>
            <th>Email du Président</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

        <!-- fonction pour récupérer les associations -->
        <?php $associations = getAssociationsWithPresidents($dbConnection); ?>

        <?php foreach ($associations as $association) : ?>
            <tr>
                <td><?= ($association['id']) ?></td>
                <td><?= ($association['association_name']) ?></td>
                <td><?= ($association['president_name']) ?></td>
                <td><?= ($association['president_first_name']) ?></td>
                <td><?= ($association['president_email']) ?></td>
                <td><a href="/ctrl/association/details.php?id=<?= ($association['id']) ?>"><button>Détails</button></a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>