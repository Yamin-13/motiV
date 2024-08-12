<h1>Liste des Mairies</h1>
<table class="user-management-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom de la Mairie</th>
            <th>Nom de l'Administrateur</th>
            <th>Prénom de l'Administrateur</th>
            <th>Email de l'Administrateur</th>
            <th>Numéro de téléphone de la Mairie</th>
            <th>Action</th>
        </tr>
    </thead>

    <!-- fonction pour récupérer les partenaires -->
    <?php $cityHalls = getCityHallsWithDetails($dbConnection); ?>

    <tbody>
        <?php foreach ($cityHalls as $cityHall) : ?>
            <tr>
                <td><?= ($cityHall['id']) ?></td>
                <td><?= ($cityHall['city_hall_name']) ?></td>
                <td><?= ($cityHall['admin_name']) ?></td>
                <td><?= ($cityHall['admin_first_name']) ?></td>
                <td><?= ($cityHall['admin_email']) ?></td>
                <td><?= ($cityHall['city_hall_phone_number']) ?></td>
                <td><a href="/ctrl/city-hall/details.php?id=<?= ($cityHall['id']) ?>"><button>Détails</button></a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>