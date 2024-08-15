<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/student.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/educational-establishment.php';

$dbConnection = getConnection($dbConfig);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $classId = $_POST['class_id'];

    // Récupére les élèves de la classe en attente de validation
    $students = getStudentsByClassId($classId, $dbConnection);

    foreach ($students as $student) {
        // Vérifie si un utilisateur avec ce numéro INE existe dans la table user
        $user = getUserByIne($student['ine_number'], $dbConnection);

        if ($user) {
            // Mets à jour les informations de l'étudiant avec les informations de l'utilisateur existant
            updateStudentInfo($student['id'], $user['name'], $user['first_name'], $user['email'], $dbConnection);
        }

        // Valide l'élève
        validateStudent($student['id'], $dbConnection);
    }

    $_SESSION['success'] = "Tous les élèves de la classe ont été validés.";
    header('Location: /ctrl/educational-establishment/student-list.php');
    exit();
}
