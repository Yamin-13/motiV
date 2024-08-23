<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/student.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/point.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/educational-establishment.php';

$dbConnection = getConnection($dbConfig);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $classId = $_POST['class_id'];

    // Récupère la valeur des points de validation INE depuis la configuration du site
    $query = "SELECT key_value FROM site_configuration WHERE key_name = 'ine_validation_points'";
    $statement = $dbConnection->prepare($query);
    $statement->execute();
    $ineValidationPoints = $statement->fetchColumn();

    // Récupère les élèves de la classe en attente de validation
    $students = getStudentsByClassId($classId, $dbConnection);

    foreach ($students as $student) {
        // Vérifie si un utilisateur avec ce numéro INE existe dans la table user
        $user = getUserByIne($student['ine_number'], $dbConnection);

        if ($user) {
            // Mets à jour les informations de l'étudiant avec les informations de l'utilisateur existant
            updateStudentInfo($student['id'], $user['name'], $user['first_name'], $user['email'], $dbConnection);
            
            // Ajoute les points de validation INE à l'utilisateur si c'est pas déjà fait
            if ($user['points'] == 0) {
                // Apel à la fonction awardPoints pour attribuer les points
                awardPoints($user['id'], $ineValidationPoints, 'Tes efforts en classe sont récompensés !', $dbConnection);
        
                // Mise à jour de la session si l'utilisateur est connecté
                if ($_SESSION['user']['id'] == $user['id']) {
                    $_SESSION['user']['points'] += $ineValidationPoints;
                }
            }
        }

        // Valide l'élève
        validateStudent($student['id'], $dbConnection);
    }

    $_SESSION['success'] = "Tous les élèves de la classe ont été validés.";
    header('Location: /ctrl/educational-establishment/student-list.php');
    exit();
}