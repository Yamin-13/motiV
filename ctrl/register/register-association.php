<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/association.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $phone_number = htmlspecialchars($_POST['phone_number']);
    $address = htmlspecialchars($_POST['address']);
    $email = htmlspecialchars($_POST['email']);
    $idUser = $_SESSION['user']['id'];

    $dbConnection = getConnection($dbConfig);

    if (addAssociation($name, $description, $phone_number, $address, $idUser, $email, $dbConnection)) {
        $_SESSION['success'] = 'Inscription de l\'association réussie.';
        header('Location: /ctrl/profile/display.php');
        exit();
    } else {
        $_SESSION['error'] = 'Erreur lors de l\'inscription de l\'association.<br> Veuillez réessayer.';
        header('Location: /ctrl/register/display-association-partner.php');
        exit();
    }
}
