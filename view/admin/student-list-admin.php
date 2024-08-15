<?php if (!empty($validatedStudents)) : ?>
    <?php foreach ($validatedStudents as $establishmentName => $students) : ?>
        <h2><?= $establishmentName ?></h2>
        <table>
            <thead>
                <tr>
                    <th>Nom du professeur</th>
                    <th>Classe</th>
                    <th>Numéro INE de l'élève</th>
                    <th>Nom de l'élève</th>
                    <th>Prénom de l'élève</th>
                    <th>Email de l'élève</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student) : ?>
                    <tr>
                        <td><?= $student['professor_first_name'] . ' ' . $student['professor_name'] ?></td>
                        <td><?= $student['class_name'] ?></td>
                        <td><?= $student['ine_number'] ?></td>
                        <td><?= isset($student['student_first_name']) ? $student['student_first_name'] : 'Utilisateur non inscrit' ?></td>
                        <td><?= isset($student['student_name']) ? $student['student_name'] : 'Utilisateur non inscrit' ?></td>
                        <td><?= isset($student['student_email']) ? $student['student_email'] : 'Utilisateur non inscrit' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endforeach; ?>
<?php else : ?>
    <p>Aucun élève validé pour le moment.</p>
<?php endif; ?>
