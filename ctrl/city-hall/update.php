<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/city-hall.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = htmlspecialchars($_POST['name']);
    $phoneNumber = htmlspecialchars($_POST['phone_number']);
    $address = htmlspecialchars($_POST['address']);
    $email = htmlspecialchars($_POST['email']);
    $imageFilename = $_FILES['image_filename']['name'];

    // Traitement du fichier image
    if (!empty($imageFilename)) {
        $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
        $uploadPath = $uploadDirectory . basename($imageFilename);
        move_uploaded_file($_FILES['image_filename']['tmp_name'], $uploadPath);
    }

    $dbConnection = getConnection($dbConfig);

    if (updateCityHall($id, $name, $phoneNumber, $address, $email, $imageFilename, $dbConnection)) {
        $_SESSION['success'] = 'Mairie mise à jour avec succès.';
    } else {
        $_SESSION['error'] = 'Erreur lors de la mise à jour de la mairie.';
    }

    header('Location: /ctrl/profile/display.php?id=' . $id);
    exit();
}