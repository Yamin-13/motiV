<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/student.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/educational-establishment.php';

$titrePage = "Liste des élèves validés";

// Vérification du rôle de l'utilisateur
$idRole = $_SESSION['user']['idRole'];
if ($idRole != 10) { // vérifie si l'utilisateur est un admin de la plateforme
    header('Location: /ctrl/login/login-display.php');
    exit();
}

$dbConnection = getConnection($dbConfig);

// recupère la liste des élèves validés groupés par établissement scolaire
$validatedStudents = getValidatedStudentsByEstablishment($dbConnection);

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/admin/student-list-admin.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';