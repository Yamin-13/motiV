<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';

$idUser = $_SESSION['user']['id'];
$newName = $_POST['name'] ?? $_SESSION['user']['name'];
$newEmail = $_POST['email'] ?? $_SESSION['user']['email'];
$newFirstName = $_POST['first_name'] ?? $_SESSION['user']['first_name'];
$newDateOfBirth = $_POST['date_of_birth'] ?? $_SESSION['user']['date_of_birth'];
$newAddress = $_POST['address'] ?? $_SESSION['user']['address'];
$avatarFilename = $_SESSION['user']['avatar_filename'];

// Traitement de l'upload du nouvel avatar
if (!empty($_FILES['avatar']['name'])) {
    $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
    $avatarFilename = basename($_FILES['avatar']['name']);
    $uploadPath = $uploadDirectory . $avatarFilename;

    if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadPath)) {
        die('Erreur lors de l\'upload de l\'avatar.');
    }
}

// Vérification et hachage du nouveau mot de passe s'il est fourni
$newPassword = $_SESSION['user']['password'];
if (!empty($_POST['password']) && $_POST['password'] === $_POST['confirm_password']) {
    $newPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);
} elseif (!empty($_POST['password']) && $_POST['password'] !== $_POST['confirm_password']) {
    $_SESSION['error'] = 'Les mots de passe ne correspondent pas.';
    header('Location: /ctrl/young/profile.php');
    exit();
}

// Mise à jour de l'utilisateur dans la base de données
$dbConnection = getConnection($dbConfig);
updateUserProfile($newName, $idUser, $newEmail, $avatarFilename, $newFirstName, $newPassword, $_SESSION['user']['idRole'], $newAddress, $newDateOfBirth, $dbConnection);

// Mise à jour des informations de session
$_SESSION['user']['name'] = $newName;
$_SESSION['user']['email'] = $newEmail;
$_SESSION['user']['first_name'] = $newFirstName;
$_SESSION['user']['avatar_filename'] = $avatarFilename;
$_SESSION['user']['date_of_birth'] = $newDateOfBirth;
$_SESSION['user']['address'] = $newAddress;
$_SESSION['user']['password'] = $newPassword;

// Ajout d'un message de confirmation
$_SESSION['success'] = "Votre profil a été mis à jour avec succès.";

header('Location: /ctrl/young/profile.php');
exit();