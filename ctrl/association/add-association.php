<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/association.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['association_name']);
    $email = htmlspecialchars($_POST['association_email']);
    $rne = htmlspecialchars($_POST['association_rne']);
    $address = htmlspecialchars($_POST['association_address']);
    $idUser = $_SESSION['user']['id'];
    $status = 'pending';

    $dbConnection = getConnection($dbConfig);

    if (addAssociation($name, '', $rne, $address, $idUser, $email, $dbConnection)) {
        $_SESSION['success'] = 'Association ajoutée avec succès.';
    } else {
        $_SESSION['error'] = 'Erreur lors de l\'ajout de l\'association. Veuillez réessayer.';
    }

    header('Location: /ctrl/profile/display.php');
    exit();
}