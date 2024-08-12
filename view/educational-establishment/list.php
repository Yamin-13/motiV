<h1>Liste des Établissements Scolaires</h1>
<table class="user-management-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom de l'Établissement</th>
            <th>Nom de l'Administrateur</th>
            <th>Prénom de l'Administrateur</th>
            <th>Email de l'Administrateur</th>
            <th>Numéro de téléphone de l'Établissement</th>
            <th>Action</th>
        </tr>
    </thead>

    <!-- fonction pour récupérer les établissements scolaires -->
    <?php $educationalEstablishments = getEducationalEstablishmentsWithDetails($dbConnection); ?>

    <tbody>
        <?php foreach ($educationalEstablishments as $educationalEstablishment) : ?>
            <tr>
                <td><?= ($educationalEstablishment['id']) ?></td>
                <td><?= ($educationalEstablishment['establishment_name']) ?></td>
                <td><?= ($educationalEstablishment['admin_name']) ?></td>
                <td><?= ($educationalEstablishment['admin_first_name']) ?></td>
                <td><?= ($educationalEstablishment['admin_email']) ?></td>
                <td><?= ($educationalEstablishment['establishment_phone_number']) ?></td>
                <td><a href="/ctrl/educational-establishment/details.php?id=<?= ($educationalEstablishment['id']) ?>"><button>Détails</button></a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>