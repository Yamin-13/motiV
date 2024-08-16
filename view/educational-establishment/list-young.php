<h1>Liste des Jeunes de l'Établissement</h1>

<?php if (isset($_SESSION['success'])) : ?>
    <div class="success-message">
        <?= $_SESSION['success'] ?>
        <?php unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])) : ?>
    <div class="error-message">
        <?= $_SESSION['error'] ?>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<table class="user-management-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Nombre de points</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($youngUsers as $user) : ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= $user['name'] ?></td>
                <td><?= $user['first_name'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['points'] ?></td>
                <td>
                    <a href="/ctrl/educational-establishment/student-details.php?id=<?= $user['id'] ?>"><button>Détails</button></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>