<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/student.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/professor.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/educational-establishment.php';

$dbConnection = getConnection($dbConfig);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupére l'ID du professeur depuis la table professor_user
    $professor = getProfessorByIdUser($_SESSION['user']['id'], $dbConnection);
    
    if (!$professor) {
        $_SESSION['error'] = "Professeur non valide.";
        header('Location: /ctrl/profile/display.php');
        exit();
    }

    $professorId = $professor['id'];  // L'ID correct provenant de professor_user
    $establishmentId = $professor['idEducationalEstablishment'];  // L'ID de l'établissement

    // Vérification que le professeur peut ajouter des élèves
    if (!canAddMoreStudents($professorId, $dbConnection)) {
        $_SESSION['error'] = "Vous ne pouvez pas ajouter plus de 8 élèves.";
        header('Location: /ctrl/profile/display.php');
        exit();
    }

    $studentsAdded = 0;

    for ($i = 1; $i <= 8; $i++) {
        $ine_number = $_POST['ine_number_' . $i];
        if (!empty($ine_number)) {
            if (addStudent($ine_number, $professorId, $establishmentId, $dbConnection)) {
                $studentsAdded++;
            }
        }
    }

    if ($studentsAdded > 0) {
        $_SESSION['success'] = "$studentsAdded élèves ajoutés avec succès.";
    } else {
        $_SESSION['error'] = "Aucun élève n'a été ajouté.";
    }

    header('Location: /ctrl/profile/display.php');
    exit();
}
