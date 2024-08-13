<h1>Liste des élèves validés par établissement scolaire</h1>

<?php if (!empty($validatedStudents)) : ?>
    <?php foreach ($validatedStudents as $establishmentName => $students) : ?>
        <h2><?= $establishmentName ?></h2>
        <table>
            <thead>
                <tr>
                    <th>Nom du professeur</th>
                    <th>Classe</th>
                    <th>Numéro INE de l'élève</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student) : ?>
                    <tr>
                        <td><?= $student['professor_first_name'] . ' ' . $student['professor_name'] ?></td>
                        <td><?= $student['class_name'] ?></td>
                        <td><?= $student['ine_number'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endforeach; ?>
<?php else : ?>
    <p>Aucun élève validé pour le moment.</p>
<?php endif; ?>