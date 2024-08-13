<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/student.php';

$dbConnection = getConnection($dbConfig);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $studentId = $_POST['id'];
    $ine_number = $_POST['ine_number'];

    if (updateStudent($studentId, $ine_number, $dbConnection)) {
        $_SESSION['success'] = "L'élève a été mis à jour avec succès.";
    } else {
        $_SESSION['error'] = "Erreur lors de la mise à jour de l'élève.";
    }

    header('Location: /ctrl/profile/display.php');
    exit();
}