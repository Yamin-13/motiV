<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/partner.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = htmlspecialchars($_POST['name']);
    $siretNumber = htmlspecialchars($_POST['siret_number']);
    $address = htmlspecialchars($_POST['address']);
    $email = htmlspecialchars($_POST['email']);

    $dbConnection = getConnection($dbConfig);

    if (updatePartner($id, $name, $siretNumber, $address, $email, $dbConnection)) {
        $_SESSION['success'] = 'Entreprise mise à jour avec succès.';
    } else {
        $_SESSION['error'] = 'Erreur lors de la mise à jour de l\'entreprise.';
    }

    header('Location: /ctrl/profile/display.php?id=' . $id);
    exit();
}