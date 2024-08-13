<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/educational-establishment.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dbConnection = getConnection($dbConfig);

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phoneNumber = htmlspecialchars($_POST['phone_number']);
    $address = htmlspecialchars($_POST['address']);
    $RNE_number = htmlspecialchars($_POST['RNE_number']);
    $idUser = $_SESSION['user']['id'];

    if (addEducationalEstablishment($name, $email, $phoneNumber, $address, $RNE_number, $idUser, $dbConnection)) {
        $_SESSION['success'] = 'Établissement scolaire ajouté avec succès.';
        header('Location: /ctrl/profile/display.php');
        exit();
    } else {
        $_SESSION['error'] = 'Erreur lors de l\'ajout de l\'établissement scolaire.';
        header('Location: /view/educational-establishment/add-educational-establishment.php');
        exit();
    }
}
