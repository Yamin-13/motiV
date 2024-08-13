<h1>Liste des Élèves par Classe</h1>

<?php if (!empty($professorStudents)): ?>
    <?php foreach ($professorStudents as $professor): ?>
        <h2>Classe: <?= $professor['class_name'] ?> (Professeur: <?= $professor['professor_first_name'] . ' ' . $professor['professor_name'] ?>)</h2>
        <table class="student-list-table">
            <thead>
                <tr>
                    <th>Numéro INE</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($professor['students'] as $student): ?>
                    <tr>
                        <td><?= $student['ine_number'] ?></td>
                        <td><?= ucfirst($student['status']) ?></td>
                        <td>
                            <?php if ($student['status'] == 'pending'): ?>
                                <form action="/ctrl/educational-establishment/validate-student.php" method="POST">
                                    <input type="hidden" name="student_id" value="<?= $student['id'] ?>">
                                    <button type="submit">Valider</button>
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