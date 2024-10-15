<h2>Liste des Élèves par Classe</h2>

<?php if (!empty($professorStudents)): ?>
    <?php foreach ($professorStudents as $professor): ?>
        <h2>Classe: <?= ($professor['class_name']) ?> (Professeur principal: <?= ($professor['first_name'] . ' ' . $professor['name']) ?>)</h2>
        <form action="/ctrl/educational-establishment/validate-class.php" method="POST">
            <input type="hidden" name="class_id" value="<?= ($professor['id']) ?>">
            <button type="submit">Valider toute la classe</button>
        </form>
        <table class="student-list-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Numéro INE</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
    <?php foreach ($professor['students'] as $student): ?>
        <tr>
            <td><?= $student['name'] ?: 'Non spécifié' ?></td>
            <td><?= $student['first_name'] ?: 'Non spécifié' ?></td>
            <td><?= $student['ine_number'] ?: 'Non spécifié' ?></td>
            <td><?= $student['status'] ?></td>
            <td>
                <?php if ($student['status'] == 'pending'): ?>
                    <a href="/ctrl/educational-establishment/student-details.php?id=<?= $student['user_id'] ?>"><button>Détails</button></a>
                    <a href="/ctrl/professor/edit-student.php?id=<?= ($student['id']) ?>"><button>Modifier</button></a>
                    <form action="/ctrl/professor/delete-student.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= ($student['id']) ?>">
                        <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élève ?');">Supprimer</button>
                    </form>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>

        </table>
    <?php endforeach; ?>
<?php else: ?>
    <p>Aucun élève en attente.</p>
<?php endif; ?>