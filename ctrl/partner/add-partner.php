<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/partner.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['partner_name']);
    $email = htmlspecialchars($_POST['partner_email']);
    $siret = htmlspecialchars($_POST['partner_siret']);
    $address = htmlspecialchars($_POST['partner_address']);
    $idUser = $_SESSION['user']['id'];
    $status = 'pending';

    $dbConnection = getConnection($dbConfig);

    if (addPartner($name, $email, $siret, $address, $idUser, $status, $dbConnection)) {
        $_SESSION['success'] = 'Partenaire ajouté avec succès.';
    } else {
        $_SESSION['error'] = 'Erreur lors de l\'ajout du partenaire. Veuillez réessayer.';
    }

    header('Location: /ctrl/profile/display.php');
    exit();
}
