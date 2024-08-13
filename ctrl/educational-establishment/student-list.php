<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/student.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/professor.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/educational-establishment.php';

$dbConnection = getConnection($dbConfig);
$titrePage = "motiV";

$idUser = $_SESSION['user']['id'];
$educationalEstablishment = getEducationalEstablishmentByIdUser($idUser, $dbConnection);

if (!$educationalEstablishment) {
    $_SESSION['error'] = "Établissement non trouvé.";
    header('Location: /ctrl/profile/display.php');
    exit();
}

// Récupere la liste des professeurs et des étudiants par établissement
$professorStudents = getProfessorStudentsByEstablishment($educationalEstablishment['id'], $dbConnection);

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/educational-establishment/student-list.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';