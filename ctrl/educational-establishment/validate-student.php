<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/educational-establishment.php';

$dbConnection = getConnection($dbConfig);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $studentId = $_POST['student_id'];

    if (validateStudent($studentId, $dbConnection)) {
        $_SESSION['success'] = "L'élève a été validé avec succès.";
    } else {
        $_SESSION['error'] = "Erreur lors de la validation de l'élève.";
    }

    header('Location: /ctrl/educational-establishment/student-list.php');
    exit();
}