<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/student.php';

$dbConnection = getConnection($dbConfig);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $classId = $_POST['class_id'];

    if (validateClass($classId, $dbConnection)) {
        $_SESSION['success'] = "Tous les élèves de la classe ont été validés.";
    } else {
        $_SESSION['error'] = "Erreur lors de la validation des élèves de la classe.";
    }

    header('Location: /ctrl/educational-establishment/student-list.php');
    exit();
}