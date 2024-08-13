<h1>Liste des Élèves par Classe</h1>

<?php if (!empty($professorStudents)): ?>
    <?php foreach ($professorStudents as $professor): ?>
        <h2>Classe: <?= $professor['class_name'] ?> (Professeur: <?= $professor['professor_first_name'] . ' ' . $professor['professor_name'] ?>)</h2>
        <form action="/ctrl/educational-establishment/validate-class.php" method="POST">
            <input type="hidden" name="class_id" value="<?= $professor['id'] ?>">
            <button type="submit">Valider toute la classe</button>
        </form>
        <table class="student-list-table">
            <thead>
                <tr>
                    <th>Numéro INE</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($professor['students'] as $student): ?>
                    <tr>
                        <td><?= $student['ine_number'] ?></td>
                        <td><?= ucfirst($student['status']) ?></td>
                        <td>
                            <?php if ($student['status'] == 'pending'): ?>
                                <a href="/ctrl/professor/edit-student.php?id=<?= $student['id'] ?>"><button>Modifier</button></a>
                                <form action="/ctrl/professor/delete-student.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $student['id'] ?>">
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
