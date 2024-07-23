<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/partner.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $siret_number = htmlspecialchars($_POST['siret_number']);
    $address = htmlspecialchars($_POST['address']);
    $idUser = $_SESSION['user']['id'];

    $dbConnection = getConnection($dbConfig);

    if (addPartner($name, $siret_number, $address, $idUser, $dbConnection)) {
        $_SESSION['success'] = 'Inscription du partenaire réussie.';
        header('Location: /ctrl/partner/profile.php');
        exit();
    } else {
        $_SESSION['error'] = 'Erreur lors de l\'inscription du partenaire.<br> Veuillez réessayer.';
        header('Location: /view/partner/register.php');
        exit();
    }
}
