<h1>Profil de <?= ($user['first_name'] . ' ' . $user['name']) ?></h1>
<p>Email: <?= ($user['email']) ?></p>
<p>Classe: <?= ($professor['class_name']) ?></p>

<h2>Informations sur l'Établissement Scolaire</h2>

<?php if ($educationalEstablishment) : ?>
    <p>Nom de l'établissement: <?= ($educationalEstablishment['name']) ?></p>
    <p>Numéro RNE: <?= ($educationalEstablishment['RNE_number']) ?></p>
    <p>Numéro de téléphone: <?= ($educationalEstablishment['phone_number']) ?></p>
    <p>Adresse: <?= ($educationalEstablishment['address']) ?></p>
    <p>Email de l'établissement: <?= ($educationalEstablishment['email']) ?></p>
<?php else : ?>
    <p>Aucune information sur l'établissement scolaire disponible.</p>
<?php endif; ?>

<h2>Ajouter des élèves</h2>
<form action="/ctrl/professor/add-students.php" method="POST">
    <?php for ($i = 1; $i <= 8; $i++) : ?>
        <label for="ine_number_<?= $i ?>">Numéro INE <?= $i ?>:</label>
        <input type="text" id="ine_number_<?= $i ?>" name="ine_number_<?= $i ?>"><br>
    <?php endfor; ?>
    <button type="submit">Ajouter les élèves</button>
</form>

<?php if (isset($_SESSION['success'])) : ?>
    <div class="success-message">
        <?= ($_SESSION['success']) ?>
        <?php unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])) : ?>
    <div class="error-message">
        <?= ($_SESSION['error']) ?>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<h2>Liste des Élèves</h2>
<?php if (!empty($students)) : ?>
    <table>
        <thead>
            <tr>
                <th>Numéro INE</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student) : ?>
                <tr>
                    <td><?= $student['ine_number'] ?></td>
                    <td><?= ucfirst($student['status']) ?></td>
                </tr>
           <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>Aucun élève ajouté.</p>
<?php endif; ?>

<a href="/ctrl/login/logout.php">Se déconnecter</a>