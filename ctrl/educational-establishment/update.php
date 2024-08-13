<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/educational-establishment.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = htmlspecialchars($_POST['name']);
    $phoneNumber = htmlspecialchars($_POST['phone_number']);
    $address = htmlspecialchars($_POST['address']);
    $email = htmlspecialchars($_POST['email']);
    $RNE_number = htmlspecialchars($_POST['RNE_number']);

    $dbConnection = getConnection($dbConfig);


    if (updateEducationalEstablishment($id, $name, $phoneNumber, $address, $email, $RNE_number, $dbConnection)) {
        $_SESSION['success'] = 'Établissement scolaire mis à jour avec succès.';
    } else {
        $_SESSION['error'] = 'Erreur lors de la mise à jour de l\'établissement scolaire.';
    }

    echo 'Success: ' . $_SESSION['success'] . '<br>';
    echo 'Error: ' . $_SESSION['error'] . '<br>';

    header('Location: /ctrl/profile/display.php?id=' . $id);
    exit();
}
