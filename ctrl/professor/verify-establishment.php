<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/educational-establishment.php';

$dbConnection = getConnection($dbConfig);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rne_number = $_POST['rne_number'];
    $unique_code = $_POST['unique_code'];

    // Vérifie si l'établissement existe avec le numéro RNE et le code unique
    $establishment = getEducationalEstablishment($rne_number, $unique_code, $dbConnection);

    if ($establishment) {
        // Stocke l'ID de l'établissement dans la session
        $_SESSION['establishment_id'] = $establishment['id'];
        header('Location: /ctrl/professor/registration-form.php');
        exit();
    } else {
        $_SESSION['error'] = "Numéro RNE ou code unique incorrect.";
        header('Location: /ctrl/professor/register-form.php');
        exit();
    }
}