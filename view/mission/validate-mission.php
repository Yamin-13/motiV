<h1>Valider la Mission : <?= ($mission['title']) ?></h1>

<?php if (isset($_SESSION['error'])) : ?>
    <div class="error-message">
        <?= ($_SESSION['error']) ?>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['success'])) : ?>
    <div class="success-message">
        <?= ($_SESSION['success']) ?>
        <?php unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<form method="post" action="">
    <?php if (!empty($registeredUsers)) : ?>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Présence</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registeredUsers as $user) : ?>
                    <tr>
                        <td><?= ($user['first_name'] . ' ' . $user['name']) ?></td>
                        <td><?= ($user['email']) ?></td>
                        <td>
                            <label>
                                <input type="radio" name="status[<?= ($user['idUser']) ?>]" value="present" <?= ($user['marked_absent'] == 0 ? 'checked' : '') ?>> Présent
                            </label>
                            <label>
                                <input type="radio" name="status[<?= ($user['idUser']) ?>]" value="absent" <?= ($user['marked_absent'] == 1 ? 'checked' : '') ?>> Absent
                            </label>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit">Valider les présences</button>
    <?php else : ?>
        <p>Aucun jeune inscrit pour cette mission.</p>
    <?php endif; ?>
</form>

<a href="/ctrl/mission/mission-list.php">Retour à la liste des missions</a>
