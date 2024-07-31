<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/association.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $phoneNumber = htmlspecialchars($_POST['phone_number']);
    $address = htmlspecialchars($_POST['address']);
    $email = htmlspecialchars($_POST['email']);

    $dbConnection = getConnection($dbConfig);

    if (updateAssociation($id, $name, $description, $phoneNumber, $address, $email, $dbConnection)) {
        $_SESSION['success'] = 'Association mise à jour avec succès.';
    } else {
        $_SESSION['error'] = 'Erreur lors de la mise à jour de l\'association.';
    }

    header('Location: /ctrl/profile/display.php?id=' . $id);
    exit();
}
