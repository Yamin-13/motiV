<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/student.php';

$titrePage = "motiV";
$dbConnection = getConnection($dbConfig);

if (!isset($_GET['id'])) {
    header('Location: /ctrl/profile/display.php');
    exit();
}

$studentId = $_GET['id'];
$student = getStudentById($studentId, $dbConnection);

if (!$student || $student['status'] != 'pending') {
    header('Location: /ctrl/profile/display.php');
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/professor/edit-student.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';