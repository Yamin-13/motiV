<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/city-hall.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dbConnection = getConnection($dbConfig);

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phoneNumber = htmlspecialchars($_POST['phone_number']);
    $address = htmlspecialchars($_POST['address']);
    $idUser = $_SESSION['user']['id'];

    if (addCityHall($name, $email, $phoneNumber, $address, $idUser, $dbConnection)) {
        $_SESSION['success'] = 'Mairie ajoutée avec succès.';
        header('Location: /ctrl/profile/display.php');
        exit();
    } else {
        $_SESSION['error'] = 'Erreur lors de l\'ajout de la mairie.';
        header('Location: /view/city-hall/add-city-hall.php');
        exit();
    }
}