<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';

// Connexion à la base de données
$dbConnection = getConnection($dbConfig);

$idUser = $_SESSION['user']['id'];
$newFirstName = $_POST['first_name'] ?? '';
$newName = $_POST['name'] ?? '';
$newDateOfBirth = $_POST['date_of_birth'] ?? '';
$newAddress = $_POST['address'] ?? '';
$ineNumber = $_POST['ine_number'] ?? '';

// Connexion à la base de données
$dbConnection = getConnection($dbConfig);

// Mise à jour de l'utilisateur dans la base de données
updateUserProfile($idUser, $newName, $_SESSION['user']['email'], $_SESSION['user']['avatar_filename'], $newFirstName, $_SESSION['user']['password'], $_SESSION['user']['idRole'], $ineNumber, $newAddress, $newDateOfBirth, $dbConnection);

// Mise à jour des informations de session
$_SESSION['user']['name'] = $newName;
$_SESSION['user']['first_name'] = $newFirstName;
$_SESSION['user']['date_of_birth'] = $newDateOfBirth;
$_SESSION['user']['address'] = $newAddress;
$_SESSION['user']['profile_complete'] = 1;

// Ajout d'un message de confirmation
$_SESSION['success'] = "Votre profil a été mis à jour avec succès.";

// vers la page de profil
header('Location: /ctrl/young/profile.php');
exit();
