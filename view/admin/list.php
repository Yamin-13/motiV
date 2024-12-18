<h1>Gestion des Utilisateurs par Rôle</h1>

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

<a href="/ctrl/admin/profile.php">retour vers profile</a>

<?php
$currentRole = '';
foreach ($users as $user) :
    if ($currentRole !== $user['role']) :
        if ($currentRole !== '') :
            echo '</tbody></table>';
        endif;

        $currentRole = $user['role'];
        ?>
        <h2> <?= getReadableRole($currentRole) ?> :</h2>
        <table class="user-management-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Dernière Connexion</th>
                    <?php if ($user['idRole'] == 60) : ?>
                        <th>Nombre de points</th>
                    <?php endif; ?>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
    <?php endif; ?>

    <tr>
        <td><?= $user['id'] ?></td>
        <td><?= $user['name'] ?></td>
        <td><?= $user['first_name'] ?></td>
        <td><?= $user['email'] ?></td>
        <td><?= $user['last_connexion'] ?></td> 
        <?php if ($user['idRole'] == 60) : ?>
            <td><?= $user['points'] ?></td>
        <?php endif; ?>
        <td>
            <a href="/ctrl/admin/user-details.php?id=<?= $user['id'] ?>"><button>Détails</button></a>
        </td>
    </tr>
<?php endforeach; ?>

<?php if ($currentRole !== '') : ?>
    </tbody></table>
<?php endif; ?>