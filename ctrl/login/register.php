<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';

// se connecte à la BDD
$dbConnection = getConnection($dbConfig);

$_SESSION['msg']['info'] = [];
$_SESSION['msg']['error'] = [];

// lis les informations saisies dans le formulaire
$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);
$confirmPassword = htmlspecialchars($_POST['confirm_password']);
// si le champ name est vide le laisse vide ou NULL dans la BDD
$name = !empty($_POST['name']) ? htmlspecialchars($_POST['name']) : null;
$firstName = htmlspecialchars($_POST['first_name'] ?? ''); 
$address = htmlspecialchars($_POST['address'] ?? ''); 
$dateOfBirth = htmlspecialchars($_POST['date_of_birth'] ?? ''); 
$points = 0;
$ine_number = '';

// Vérifie si les mots de passe corresponde
if ($password !== $confirmPassword) {
    $_SESSION['error'] = 'Les mots de passe ne correspondent pas.';
    header('Location: /ctrl/login/register-display.php');
    exit();
}

// Remplace l'avatar par une image par défaut
$fileName = '/asset/img/profil-par-defaut.jpeg'; // Chemin de l'image par défaut

// Hache le mot de passe
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Role par défaut pour un nouvel utilisateur
$idRole = 60;

// Vérifie si l'email existe déjà
if (emailExists($email, $dbConnection)) {
    $_SESSION['error'] = 'L\'email existe déjà. Veuillez en utiliser un autre.';
    header('Location: /ctrl/login/register-display.php');
    exit();
}

// Ajoute l'utilisateur à la base de données sans uploader l'avatar
if (addUser($email, $name, $firstName, $hashedPassword, $idRole, $fileName, $address, $dateOfBirth, $points, $ine_number, $dbConnection)) {
    $_SESSION['success'] = 'Inscription réussie.<br>Vous pouvez maintenant vous connecter.';
    header('Location: /ctrl/login/login-display.php');
    exit();
} else {
    $_SESSION['error'] = 'Erreur lors de l\'inscription.<br> Veuillez réessayer.';
    header('Location: /ctrl/login/register-display.php');
    exit();
}